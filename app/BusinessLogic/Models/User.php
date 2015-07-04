<?php namespace App\BusinessLogic\Models;


use App\BusinessLogic\Additions\FilterAddition;
use App\BusinessLogic\Model;
use App\BusinessLogic\Models\Purchase;

/**
 * Модель Пользователь
 * Class User
 * @package App\BusinessLogic\Models
 */
class User extends \App\User
{
    public function getInstancesList($model_name, FilterAddition $filter = null)
    {
        $sql = 'SELECT * FROM ' . $model_name::getTableName();

        $params = [];

        if ($filter) {
            $sql .= ' ' . $filter->getSqlExcerpt();

            $params = $filter->getSqlParams();
        }

        $records = \DB::select($sql, $params);

        if (empty($records)) {
            return [];
        }

        $purchases_list = [];

        foreach ($records as $record) {
            $purchases_list[] = $model_name::restoreFromRecord($record);
        }

        return $purchases_list;
    }

    /**
     * Возвращает массив Закупок, возможно использование фильтра
     * @param FilterAddition|null $filter
     * @return array
     */
    public function getPurchasesList(FilterAddition $filter = null)
    {
        return $this->getInstancesList('\App\BusinessLogic\Models\Purchase', $filter);
    }

    /**
     * Возвращает массив Товаров, возможно использование фильтра
     * @param FilterAddition|null $filter
     * @return array
     */
    public function getProductsList(FilterAddition $filter = null)
    {
        return $this->getInstancesList('\App\BusinessLogic\Models\Product', $filter);
    }

    /**
     * Возвращает массив Заказов, возможно использование фильтра
     * @param FilterAddition|null $filter
     * @return array
     */
    public function getOrdersList(FilterAddition $filter = null)
    {
        return $this->getInstancesList('\App\BusinessLogic\Models\Order', $filter);
    }

    /**
     * Возвращает массив Товаров в Закупках, возможно использование фильтра
     * @param FilterAddition|null $filter
     * @return array
     */
    public function getProductsInPurchasesList(FilterAddition $filter = null)
    {
        return $this->getInstancesList('\App\BusinessLogic\Models\ProductInPurchase', $filter);
    }

    /**
     * Удаление Продукта от имени пользователя
     * @param Product $product
     */
    public function destroyProduct(Product $product)
    {
        $product->destroyOnBehalfOfUser($this);
    }

    /**
     * Удаление Закупки от имени пользователя
     * @param Purchase $purchase
     */
    public function destroyPurchase(Purchase $purchase)
    {
        $purchase->destroyOnBehalfOfUser($this);
    }

    /**
     * Удаление Товара в Закупке от имени пользователя
     * @param ProductInPurchase $product_in_purchase
     */
    public function destroyProductInPurchase(ProductInPurchase $product_in_purchase)
    {
        $product_in_purchase->destroyOnBehalfOfUser($this);
    }

    /**
     * Удаление Заказа от имени пользователя
     * @param Order $order
     */
    public function destroyOrder(Order $order)
    {
        $order->destroyOnBehalfOfUser($this);
    }
}