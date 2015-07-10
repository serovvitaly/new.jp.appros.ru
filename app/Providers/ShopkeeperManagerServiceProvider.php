<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ShopkeeperManagerServiceProvider extends ServiceProvider
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
        $this->app->singleton('ShopkeeperManager', function ($app) {
            return new \App\Services\ShopkeeperManager\ServiceProvider($app);
        });
    }
}
