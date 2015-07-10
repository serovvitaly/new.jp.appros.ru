<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CommentManagerServiceProvider extends ServiceProvider
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
        $this->app->singleton('CommentManager', function ($app) {
            return new \App\Services\CommentManager\ServiceProvider($app);
        });
    }
}
