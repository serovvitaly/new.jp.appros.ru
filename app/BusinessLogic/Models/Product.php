<?php

namespace App\BusinessLogic\Models;

use App\Models\ProductModel;

class Product extends ProductModel
{

    /**
     * Добавление Продукта в Закупку
     * @param Purchase $purchase
     * @return Product
     */
    public function appendToPurchase(Purchase $purchase)
    {
        $purchase->addProduct($this);

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