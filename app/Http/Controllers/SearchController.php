<?php

namespace App\Http\Controllers;

use App\Job;

class SearchController extends Controller
{
    public function search()
    {
        $jobs = Job::all();

        return view('search.result', compact('jobs'));
    }
}