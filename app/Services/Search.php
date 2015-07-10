<?php

namespace App\Services;

use App\Job;
use App\Location;
use App\Utility\Elastica;
use App\Transformers\JobTransformer;

use Elastica\Query;
use Elastica\Result;
use Elastica\Query as ElasticaQuery;
use Elastica\Query\QueryString;

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
        $queryString = new QueryString($params['keywords']);
        $queryString->setDefaultOperator('AND')
            ->setFields(['title', 'description']);

        $elasticaQuery = new ElasticaQuery($queryString);

        if (!is_null($start) && !is_null($limit)) {
            $elasticaQuery
                ->setFrom($start)
                ->setSize($limit)
            ;
        }

        if (!empty($params['location'])) {

            $location = Location::find($params['location']);

            $elasticaQuery->addSort([
                '_geo_distance' => [
                    'jobs.location' => [$location->lat, $location->lon],
                    'order' => 'asc',
                    'unit' => 'km'
                ]
            ]);

        } else {

            $elasticaQuery->setSort(['_score' => 'desc']);

        }

        $elasticaQuery->setHighlight([
            'order' => 'score',
            'fields' => [
                'title' => ['fragment_size' => 100],
                'description' => ['fragment_size' => 200]
            ]
        ]);

        return $elasticaQuery;
    }

    private function loadJobs($result)
    {
        $jobs = [];

        foreach ($result as $document) {
            $model = new Job();
            $jobs[] = $this->jobTransformer->toPresenter($document, $model);
        }

        return $jobs;
    }

}