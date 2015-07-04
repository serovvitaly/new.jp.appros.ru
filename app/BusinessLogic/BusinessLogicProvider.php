<?php namespace App\BusinessLogic;


use App\BusinessLogic\Models\Order;
use App\BusinessLogic\Models\Product;
use App\BusinessLogic\Models\ProductInPurchase;
use App\BusinessLogic\Models\Purchase;
use App\User;

class BusinessLogicProvider
{
    use \App\BusinessLogic\ProductProviderTrait,
        \App\BusinessLogic\PurchaseProviderTrait,
        \App\BusinessLogic\OrderProviderTrait;

    protected $app = null;

    protected $user = null;

    public function __construct($app)
    {
        $this->app = $app;

        $this->user = \Auth::user();
    }

}