<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SearcherServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Searcher', function ($app) {
            return new \App\Services\Searcher\ServiceProvider($app);
        });
    }
}
