<?php namespace App\BusinessLogic\Models;


use App\BusinessLogic\Model;
use App\Helpers\AssertHelper;

class Order extends Model
{
    static $table_name = 'orders';

    protected $product_in_purchase = null;

    protected $buyer = null;

    protected $amount = null;

    public function __construct(ProductInPurchase $product_in_purchase, $amount, User $buyer)
    {
        $this->product_in_purchase = $product_in_purchase;

        $this->amount = $amount;

        $this->buyer = $buyer;
    }

    /**
     * Ищет по ID и возвращает экземпляр класса "Заказ"
     * @param $id
     * @return Order
     * @throws \Exception
     */
    public static function findById($id)
    {
        $order_obj = self::findRecordById($id);

        if (empty($order_obj)) {
            return null;
        }

        $product = Product::findById($order_obj->product_id);
        AssertHelper::assertModel($product);

        $purchase = Purchase::findById($order_obj->purchase_id);
        AssertHelper::assertModel($purchase);

        $product_in_purchase = new ProductInPurchase($product, $purchase);
        AssertHelper::assertModel($product_in_purchase);

        $buyer_user = User::findById($order_obj->user_id);
        AssertHelper::assertModel($buyer_user);

        return new self($product_in_purchase, $order_obj->amount, $buyer_user);
    }

    /**
     * Возвращает Продукт в Закупке
     * @return ProductInPurchase|null
     */
    public function getProductInPurchase()
    {
        return $this->product_in_purchase;
    }

    /**
     * Возвращает Закупку
     * @return Purchase|null
     */
    public function getPurchase()
    {
        return $this->product_in_purchase->getPurchase();
    }

    /**
     * Возвращает Продукт
     * @return Product|null
     */
    public function getProduct()
    {
        return $this->product_in_purchase->getProduct();
    }

    public function getAmount()
    {
        return $this->amount;
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