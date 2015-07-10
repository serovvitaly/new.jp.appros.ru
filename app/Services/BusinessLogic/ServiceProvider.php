<?php

namespace App\Services\BusinessLogic;


class ServiceProvider
{
    use \App\Services\BusinessLogic\ProductProviderTrait,
        \App\Services\BusinessLogic\PurchaseProviderTrait,
        \App\Services\BusinessLogic\ProductInPurchaseProviderTrait,
        \App\Services\BusinessLogic\PaymentTransactionProviderTrait,
        \App\Services\BusinessLogic\OrderProviderTrait;

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