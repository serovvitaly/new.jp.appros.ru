<?php namespace App\BusinessLogic;


class ProductInPurchase
{
    protected $product = null;

    protected $purchase = null;

    public function __construct(Product $product, Purchase $purchase)
    {
        $this->product = $product;

        $this->purchase = $purchase;
    }

    public static function get()
    {
        //
    }

    public function getPurchase()
    {
        return $this->purchase;
    }

    public function getProduct()
    {
        return $this->product;
    }

}