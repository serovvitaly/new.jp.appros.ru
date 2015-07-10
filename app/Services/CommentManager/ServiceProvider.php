<?php

namespace App\Services\CommentManager;

/**
 * Предназначен для работы с Комментариями
 *
 * @package App\Services\CommentManager
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