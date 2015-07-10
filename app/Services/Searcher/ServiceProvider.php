<?php

namespace App\Services\Searcher;


class ServiceProvider
{
    protected $app = null;

    public function __construct($app)
    {
        $this->app = $app;

        $this->user = \Auth::user();
    }
}