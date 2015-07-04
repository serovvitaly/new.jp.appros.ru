<?php namespace App\BusinessLogic\Models;


use App\BusinessLogic\Model;

class ProductInPurchase extends Model
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

    /**
     * Удалить от имени пользователя
     * @param User $owner_user
     */
    public function destroyOnBehalfOfUser(User $owner_user)
    {
        $this->assertOwnerUser($owner_user);

        //
    }

}