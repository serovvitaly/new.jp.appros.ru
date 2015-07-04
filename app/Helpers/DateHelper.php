<?php namespace App\Helpers;

use Jenssegers\Date\Date;

class DateHelper {

    public static function getDateAgoStr($time_str)
    {
        $date = new Date($time_str);

        return $date->ago();
    }
}