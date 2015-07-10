<?php

namespace App\Services\CommentManager;


class ServiceProvider extends \Illuminate\Support\ServiceProvider
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
        /*$this->app->singleton('CommentManager', function ($app) {
            return new CommentManager($app);
        });*/


        $this->app->bind('comment', function($app){

            return new CommentManager($app);

        });
    }
}