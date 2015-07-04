<?php namespace App\BusinessLogic\Models;


class ProductInPurchase
{
    protected $product = null;

    protected $purchase = null;

    public function __construct(Product $product, Purchase $purchase)
    {
        $this->product = $product;

        $this->purchase = $purchase;
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