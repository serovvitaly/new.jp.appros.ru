<?php namespace App\BusinessLogic;


use App\BusinessLogic\Models\Product;
use App\BusinessLogic\Models\Purchase;

class ProductInPurchase
{
    protected $product = null;

    protected $purchase = null;

    public function __construct(Product $product, Purchase $purchase)
    {
        $this->product = $product;

        $this->purchase = $purchase;
    }

    public function __toString()
    {
        return json_encode([
            'product' => $this->product,
            'purchase' => $this->purchase
        ]);
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