<?php

namespace App\Providers;

use Config;
use Elastica\Client;
use App\Utility\Elastica;
use Illuminate\Support\ServiceProvider;

class ElasticaServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('elastica', function ($app) {
            return new Elastica(new Client(Config::get('elasticsearch')));
        });
    }
}
