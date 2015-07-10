<?php

namespace App\Services\ShopkeeperManager;

/**
 * Отвечает за управление Закупками, Товарами, Ценами и т.д.
 * Предназначен для партнеров-продавцов.
 *
 * @package App\Services\ShopkeeperManager
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