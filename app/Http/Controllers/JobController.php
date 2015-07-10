<?php

namespace App\Http\Controllers;

use App\Presenters\JobPresenter;
use App\Services\Search as SearchService;
use App\Job;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Transformers\JobTransformer;
use Illuminate\Http\Response;
use Input;
use Request;

class JobController extends Controller
{
    /**
     * @param $jobid
     *
     * @return \Illuminate\View\View
     */
    public function show($jobid)
    {
        try {
            $job = Job::findOrFail($jobid);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        return view('job.show', ['job' => new JobPresenter($job)]);
    }

}