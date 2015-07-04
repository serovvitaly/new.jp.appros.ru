<?php namespace App\BusinessLogic\Models;


use App\BusinessLogic\Model;

class Product extends Model
{
    static $table_name = 'products';

    public function __construct($data)
    {
        //
    }

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
     * Возвращает пользователя Владельца данного продукта
     */
    public function getOwnerUser()
    {
        //
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