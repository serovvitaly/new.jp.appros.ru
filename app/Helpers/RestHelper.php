<?php namespace App\Helpers;


class RestHelper {

    public static function exceptionAccessDenied()
    {
        return response(['success' => false, 'error' => ['message' => 'Access denied', 'code' => 403]], 403);
    }

    public static function exceptionInvalidData($data)
    {
        return response(['success' => false, 'error' => ['message' => 'Bad request', 'code' => 400, 'data' => $data]], 400);
    }

}