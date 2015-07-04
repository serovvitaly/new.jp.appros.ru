<?php namespace App\Helpers;


class BasketHelper {

    public static function getBasketContentMini()
    {
        $user = \Auth::user();

        if (!$user) {
            return null;
        }

        $purchases_quantity = $user->basket()->getPurchasesQuantity();

        return "{$purchases_quantity} покупки";
    }

}