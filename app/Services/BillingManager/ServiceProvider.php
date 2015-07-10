<?php

namespace App\Services\BillingManager;

/**
 * Предназначен для работы с Биллингом
 *
 * @package App\Services\BillingManager
 */
class ServiceProvider
{
    protected $app = null;

    public function __construct($app)
    {
        $this->app = $app;

        $this->user = \Auth::user();
    }
}