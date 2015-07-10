<?php

namespace App\Http\Controllers;

use App\Job;
use App\Presenters\JobPresenter;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Job Controller
 *
 * @author Anis Uddin Ahmad <anis.programmer@gmail.com>
 */
class JobController extends Controller
{
    public function show($jobId)
    {
        try {
            $job = Job::findOrFail($jobId);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        return view('job.show', ['job' => new JobPresenter($job)]);
    }
}