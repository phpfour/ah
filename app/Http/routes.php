<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'SearchController@home');
Route::get('/search', 'SearchController@search');
Route::get('/autocomplete', 'SearchController@autocomplete');
Route::get('/jobs/{id}', 'JobController@show');
