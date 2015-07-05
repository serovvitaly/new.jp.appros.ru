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

    /**
     * Проверяет пользователя, если пользователя нет, то выбрасывает исключение
     * @param \App\User|null $user
     * @throws Exception
     */
    public static function assertUser(\App\User $user = null)
    {
        if ($user) {
            return;
        }

        throw new \Exception('There is no user access');
    }

    /**
     * Проверяет пользователя, если пользователя нет, то выбрасывает исключение
     * @param \App\User|null $user
     * @throws Exception
     */
    public static function assertUserAsJson(\App\User $user = null)
    {
        if ($user) {
            return;
        }

        $response = new \Illuminate\Http\JsonResponse(['There is no user access'], 403);

        throw new \Illuminate\Http\Exception\HttpResponseException($response);
    }

}