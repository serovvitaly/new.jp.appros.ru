<?php namespace App\BusinessLogic;


use App\BusinessLogic\Models\Order;
use App\BusinessLogic\Models\Product;
use App\BusinessLogic\Models\ProductInPurchase;
use App\BusinessLogic\Models\Purchase;
use App\BusinessLogic\Models\User;

class BusinessLogicProvider
{
    protected $app = null;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Возвращает модель Пользователя
     * @param $id
     * @return mixed
     */
    public function getUser($id)
    {
        return \App\BusinessLogic\Models\User::find($id);
    }

    /**
     * Возвращает список моделей пользователей
     * @param Additions\FilterAddition|null $filter
     * @return mixed
     */
    public function getUsersArr(\App\BusinessLogic\Additions\FilterAddition $filter = null)
    {
        $users = \App\BusinessLogic\Models\User::get();

        return $users;
    }

    /**
     * Возвращает модель текущего пользователя
     * @return User
     */
    public static function getCurrentUser()
    {
        return new User();
    }

    /**
     * Создание Заказа
     * @param $purchase_id - ID Закупки
     * @param $product_id - ID Продукта
     * @param $amount - количество
     * @param $buyer_user_id - ID покупателя
     * @return \App\BusinessLogic\Models\Order
     */
    public static function makeOrder($purchase_id, $product_id, $amount, $buyer_user_id)
    {
        $product = Product::findById($product_id);

        $purchase = Purchase::findById($purchase_id);

        $product_in_purchase = new ProductInPurchase($product, $purchase);

        $buyer_user = User::findById($buyer_user_id);

        $order = new Order($product_in_purchase, $amount, $buyer_user);

        return $order;
    }

    /**
     * Устанавливает количество товаров в заказе
     * @param $order_id
     * @param $amount
     */
    public static function setAmountToOrder($order_id, $amount)
    {
        //
    }

    /**
     * Возвращает экземпляр модели Заказа
     * @param $order_id
     * @return \App\BusinessLogic\Models\Order
     */
    public static function getOrderById($order_id)
    {
        $order = Order::findById($order_id);
        \App\Helpers\AssertHelper::assertModel($order);

        return $order;
    }

    /**
     * Удаление Заказа
     * @param $order_id
     */
    public static function removeOrder($order_id)
    {
        $order = Order::findById($order_id);
        \App\Helpers\AssertHelper::assertModel($order);

        self::getCurrentUser()->destroyOrder($order);
    }

    public static function makePurchase()
    {
        //
    }

    public static function makeProduct(array $params)
    {
        $validator = \Validator::make($params, [
            'name' => 'required|unique:posts|max:255',
            'description' => 'required',
            'user_id' => 'required|unique:users',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors());
        }

        $product = new \App\BusinessLogic\Models\Product( (object) $params );

        return $product;
    }
}