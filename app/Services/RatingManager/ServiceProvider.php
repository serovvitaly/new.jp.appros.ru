<?php

namespace App\Services\RatingManager;

/**
 * Предназначен для работы с рейтингами Покупателей, Продавцов, Закупок, Товаров и т.д.
 *
 * @package App\Services\RatingManager
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