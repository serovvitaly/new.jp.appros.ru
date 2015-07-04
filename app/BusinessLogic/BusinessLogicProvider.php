<?php namespace App\BusinessLogic;


use App\BusinessLogic\Models\Order;
use App\BusinessLogic\Models\Product;
use App\BusinessLogic\Models\ProductInPurchase;
use App\BusinessLogic\Models\Purchase;
use App\User;

class BusinessLogicProvider
{
    protected $app = null;

    protected $user = null;

    public function __construct($app)
    {
        $this->app = $app;

        $this->user = \Auth::user();
    }

    /**
     * Возвращает модель Пользователя
     * @param $id
     * @return mixed
     */
    public function getUser($id)
    {
        return \App\User::find($id);
    }

    /**
     * Возвращает список моделей пользователей
     * @param Additions\FilterAddition|null $filter
     * @return mixed
     */
    public function getUsersArr(\App\BusinessLogic\Additions\FilterAddition $filter = null)
    {
        $users = \App\User::get();

        return $users;
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

    /**
     * Создание продукта
     * @param array $fields
     * @return Product
     * @throws \Exception
     */
    public function makeProduct(array $fields)
    {
        $validator = \Validator::make($fields, [
            'name' => 'required|max:255',
            'description' => 'max:5000'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $fields['user_id'] = $this->user->id;

        $product = \App\BusinessLogic\Models\Product::create($fields);

        return $product;
    }

    /**
     * Возвращает модель продукта
     * @param $product_id
     * @return mixed
     */
    public function getProduct($product_id)
    {
        return \App\BusinessLogic\Models\Product::find($product_id);
    }

    /**
     * Возвращает список продуктов
     * @return mixed
     */
    public function getProductsList()
    {
        return \App\BusinessLogic\Models\Product::take(50)->get();
    }

    /**
     * Изменение продукта
     * @param $product_id
     * @param array $fields
     * @return mixed
     */
    public function updateProduct($product_id, array $fields)
    {
        $validator = \Validator::make($fields, [
            'name' => 'required|max:255',
            'description' => 'max:5000'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // TODO: сделать проверку прав на изменение продукта

        $product = \App\BusinessLogic\Models\Product::find($product_id);

        if (!$product) {
            return ['Product not found'];
        }

        $product->name = $fields['name'];
        $product->description = $fields['description'];

        $product->save();

        return $product;
    }

    /**
     * Удаление продукта
     * @param $product_id
     * @return bool
     */
    public function deleteProduct($product_id)
    {
        $product = $this->user->products()->find($product_id);

        if (!$product) {
            return false;
        }

        $product->delete();

        return true;
    }
}