<?php
/**
 * Created by PhpStorm.
 * User: albano
 * Date: 03.07.2015
 * Time: 18:02
 */

namespace App\BusinessLogic\Additions;


class FilterAddition
{

    public $limit = 10;

    public $offset = 0;

    public $users = [];

    /**
     * Возвращает фрагмент SQL запроса, содержащий условия выборки
     * @return string
     */
    public function getSqlExcerpt()
    {
        return '';
    }

    /**
     * Возвращает массив параметров для SQL запроса
     * @return array
     */
    public function getSqlParams()
    {
        return [];
    }
}