<?php namespace App\BusinessLogic\Models;


use App\BusinessLogic\Model;

class Purchase extends Model
{
    static $table_name = 'purchases';

    public function __construct($data)
    {
        //
    }

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