<?php

namespace App\Services\CommentManager;


class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'comment';
    }
}