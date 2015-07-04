<?php namespace App\BusinessLogic\Models;


class Purchase extends \App\Models\PurchaseModel
{
    public function addProduct(Product $product)
    {
        new ProductInPurchase($product, $this);

        return $this;
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