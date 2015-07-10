<?php

namespace App\Services\Rating;


class ServiceProvider
{
    protected $app = null;

    public function __construct($app)
    {
        $this->app = $app;

        $this->user = \Auth::user();
    }
}