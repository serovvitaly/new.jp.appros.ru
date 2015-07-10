<?php

namespace App\Services\OrderManager;

/**
 * Предназанчен для работы с Заказами
 *
 * @package App\Services\OrderManager
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