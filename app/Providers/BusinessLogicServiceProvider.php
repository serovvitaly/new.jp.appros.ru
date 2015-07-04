<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BusinessLogicServiceProvider extends ServiceProvider
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
        $this->app->singleton('BusinessLogic', function ($app) {
            return new \App\BusinessLogic\BusinessLogicProvider($app);
        });
    }
}
