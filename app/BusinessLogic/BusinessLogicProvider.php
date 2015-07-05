<?php

namespace App\BusinessLogic;


class BusinessLogicProvider
{
    use \App\BusinessLogic\ProductProviderTrait,
        \App\BusinessLogic\PurchaseProviderTrait,
        \App\BusinessLogic\ProductInPurchaseProviderTrait,
        \App\BusinessLogic\PaymentTransactionProviderTrait,
        \App\BusinessLogic\OrderProviderTrait;

    protected $app = null;

    protected $user = null;

    public function __construct($app)
    {
        $this->app = $app;

        $this->user = \Auth::user();
    }

    public function getUser()
    {
        return $this->user;
    }

}