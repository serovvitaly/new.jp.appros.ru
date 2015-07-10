<?php

namespace App\Services;


class ServiceManager
{
    protected $app = null;

    protected $user = null;

    protected $request = null;

    public function __construct($app)
    {
        $this->app = $app;

        $this->user = $app['auth']->user();

        $this->request = $app['request'];
    }
}