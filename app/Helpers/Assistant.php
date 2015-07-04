<?php namespace App\Helpers;
/**
 *
 * @author Vitaly Serov
 */

use Exception;

class Assistant {

    public static function exception($message)
    {
        throw new Exception($message);
    }

    public static function assert()
    {
        //
    }

    public static function assertModel($model, $message = null)
    {
        if ($model instanceof \Illuminate\Database\Eloquent\Model) {
            return;
        }

        if (!$message) {
            $message = 'Переменная не является моделью';
        }

        throw new Exception($message);
    }

    public static function assertNotEmpty($variable, $message = null)
    {
        //
    }

}