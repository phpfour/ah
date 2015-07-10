<?php

namespace App\Http\Controllers;

use App\Services\Search as SearchService;

use Input;
use Request;

class SearchController extends Controller
{
    private $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function home()
    {
        return view('home', ['post' => []]);
    }

    public function search()
    {
        return view('search.result', $this->prepareSearchResultsData());
    }

    public function autocomplete()
    {
        return $this->searchService->autosuggest(Input::get('q'));
    }

    private function prepareSearchResultsData()
    {
        $limit  = 20;
        $offset = (Input::get('page', 1) - 1) * $limit;
        $range  = [$offset + 1, $offset + $limit];

        $params = [
            'keywords' => Input::get('keywords'),
            'address'  => null
        ];

        if (Input::get('location')) {
            $locations = array_map('trim', explode(';', Input::get('locations')));
            foreach ($locations as $location) {
                $params['address'][] = $location;
            }
        }

        $results = $this->searchService->query($params, $offset, $limit);
        $count = $this->searchService->count($params);

        return [
            'post'            => Request::query(),
            'results'         => $results,
            'previousPageUrl' => $this->getPreviousPageUrl($count, $limit),
            'nextPageUrl'     => $this->getNextPageUrl($count, $limit),
            'range'           => $range,
            'count'           => $count,
        ];
    }

    private function getPreviousPageUrl($count, $limit)
    {
        if ($count <= $limit) {
            return;
        }

        $page = (int) Input::get('page', 1);

        // Show previous page if possible
        if ($page > 1) {
            $page--;
            return Request::url() . '?' . http_build_query(array_merge(Request::query(), compact('page')));
        }
    }

    private function getNextPageUrl($count, $limit)
    {
        if ($count <= $limit) {
            return;
        }

        $page = (int) Input::get('page', 1);

        // Show next page if possible
        if ($page * $limit < $count) {
            $page++;
            return Request::url() . '?' . http_build_query(array_merge(Request::query(), compact('page')));
        }
    }
}