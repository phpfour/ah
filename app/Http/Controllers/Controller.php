<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\View\View;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;


    function __construct()
    {

    }
}
