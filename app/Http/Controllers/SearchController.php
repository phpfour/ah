<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $jobs = Job::all();
        return view('search.result', ['post' => $request->request->all(), 'jobs' => $jobs]);
    }
}