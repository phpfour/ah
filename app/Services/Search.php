<?php

namespace App\Services;

use App\Job;
use App\Location;
use App\Utility\Elastica;
use App\Transformers\JobTransformer;

use Elastica\Query;
use Elastica\Result;
use Elastica\Query\Filtered;
use Elastica\Query\MatchAll;
use Elastica\Query\QueryString;
use Elastica\Query as ElasticaQuery;
use Elastica\Filter\GeoDistance;

/**
 * Search Service
 *
 * Handles the core search logic of the application.
 *
 * @author Mohammad Emran Hasan <phpfour@gmail.com>
 */
class Search
{
    /**
     * @var Elastica
     */
    private $elastica;

    /**
     * @var JobTransformer
     */
    private $jobTransformer;

    public function __construct(Elastica $elastica, JobTransformer $jobTransformer)
    {
        $this->elastica = $elastica;
        $this->jobTransformer = $jobTransformer;
    }

    public function query($params, $start = 0, $limit = 20)
    {
        $query = $this->prepareQuery($params, $start, $limit);
        $result = $this->elastica->search($query, 'jobs');

        return $this->loadJobs($result);
    }

    public function count($params)
    {
        $query = $this->prepareQuery($params);
        $query->setFields([]);

        return $this->elastica->count($query, 'jobs');
    }

    public function autosuggest($text)
    {
        $queryString = new QueryString($text);

        $elasticaQuery = new ElasticaQuery($queryString);
        $elasticaQuery->setSize(10);

        $result = $this->elastica->search($elasticaQuery, 'locations');
        return $this->prepareSuggestResult($result);
    }

    private function prepareSuggestResult($results)
    {
        $suggests = [];

        /** @var Result $result */
        foreach ($results as $result) {

            $suggests[] = [
                'id'   => $result->getId(),
                'name' => $result->zip_code,
            ];

            $suggests[] = [
                'id'   => $result->getId(),
                'name' => $result->city . ', ' . $result->state,
            ];

            $suggests[] = [
                'id'   => $result->getId(),
                'name' => $result->full_address,
            ];

        }

        return $suggests;
    }

    /**
     * @return ElasticaQuery
     */
    private function prepareQuery($params, $start = null, $limit = null)
    {
        $query  = null;
        $filter = null;
        $sort   = ['_score' => 'desc'];

        // We'd like to search in both title and description for keywords
        if (!empty($params['keywords'])) {
            $query = new QueryString($params['keywords']);
            $query->setDefaultOperator('AND')
                ->setFields(['title', 'description']);
        }

        // Add location filter is location is selected from autosuggest
        if (!empty($params['location_id'])) {

            $location = Location::find($params['location_id']);

            $filter = new GeoDistance('location', [
                'lat' => $location->lat,
                'lon' => $location->lon
            ], $params['radius'] . 'mi');

            // Sort by nearest hit
            $sort = [
                '_geo_distance' => [
                    'jobs.location' => [(float) $location->lon, (float) $location->lat],
                    'order' => 'asc',
                    'unit' => 'mi'
                ]
            ];

        }

        // If neither keyword nor location supplied, then return all
        if (empty($params['keywords']) && empty($params['location_id'])) {
            $query = new MatchAll();
        }

        // We need a filtered query
        $elasticaQuery = new ElasticaQuery(new Filtered($query, $filter));
        $elasticaQuery->addSort($sort);

        // Offset and limits
        if (!is_null($start) && !is_null($limit)) {
            $elasticaQuery
                ->setFrom($start)
                ->setSize($limit)
            ;
        }

        // Set up the highlight
        $elasticaQuery->setHighlight([
            'order'  => 'score',
            'fields' => [
                'title'       => ['fragment_size' => 100],
                'description' => ['fragment_size' => 200]
            ]
        ]);

        return $elasticaQuery;
    }

    private function loadJobs($result)
    {
        $jobs = [];

        foreach ($result as $document) {
            $jobs[] = $this->jobTransformer->toPresenter($document, new Job());
        }

        return $jobs;
    }

}