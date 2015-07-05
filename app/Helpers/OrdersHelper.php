<?php namespace App\Helpers;


class OrdersHelper
{

    /**
     * ���������� �������������� ������� ��� ���������� ������������
     * @param $user_id
     * @param $take
     * @param $offset
     * @return array
     */
    public static function getPurchasesIdsArrByUserId($user_id, $take = 10, $offset = 0)
    {
        $orders_models = \App\BusinessLogic\Models\Order::where('user_id', '=', $user_id)->groupBy('purchase_id')->orderBy('created_at', 'desc')->take($take)->offset($offset)->get(['purchase_id']);

        if (!$orders_models->count()) {
            return [];
        }

        $purchases_ids_arr = [];

        foreach ($orders_models as $order_model) {
            $purchases_ids_arr[] = $order_model->purchase_id;
        }

        return $purchases_ids_arr;
    }

    public static function getOrdersModelsArrByPurchasesIdsArrAndByUserId($user_id, array $purchases_ids_arr)
    {
        $orders_models = \App\BusinessLogic\Models\Order::where('user_id', '=', $user_id)->whereIn('purchase_id', $purchases_ids_arr)->orderBy('created_at', 'desc')->get();

        if (!$orders_models->count()) {
            return [];
        }

        $orders_models_arr = [];

        foreach ($orders_models as $order_model) {
            $orders_models_arr[$order_model->purchase_id][] = $order_model;
        }

        return $orders_models_arr;
    }

    public static function getProductsInPurchasesIdsArrByPurchasesIdsArrAndByUserId($user_id, array $purchases_ids_arr)
    {
        $orders_models = \App\BusinessLogic\Models\Order::where('user_id', '=', $user_id)->whereIn('purchase_id', $purchases_ids_arr)->orderBy('created_at', 'desc')->get();

        if (!$orders_models->count()) {
            return [];
        }

        $products_ids_arr = [];

        foreach ($orders_models as $order_model) {
            $products_ids_arr[$order_model->purchase_id][] = $order_model->purchase_id;
        }

        return $products_ids_arr;
    }

    public static function getTotalPrice($price, $amount)
    {
        return (double) $price * $amount;
    }

    /**
     * @param $purchase_id
     * @return array
     */
    public static function getOrdersCollectionsByPurchaseIdAndByUserId($purchase_id, $user_id)
    {
        $orders = \DB::table(\App\Basket::TABLE_PRODUCTS_IN_BASKETS)
            ->select('*')
            ->where('user_id', '=', $user_id)
            ->where('purchase_id', '=', $purchase_id)
            ->get();

        $user = \App\User::find($user_id);
        \App\Helpers\Assistant::assertModel($user);

        $orders_models = $user->orders()->where('purchase_id', '=', $purchase_id)->get();

        if (!$orders_models->count()) {
            return [];
        }

        $orders_collections_arr = [];

        foreach ($orders_models as $order_model) {
            $order_collection = new \stdClass();

            $order_collection->order_id = $order_model->id;
            $order_collection->amount = $order_model->amount;
            $order_collection->purchase_id = $order_model->purchase_id;
            $order_collection->product_id = $order_model->product_id;
            $order_collection->product_in_purchase_id = $order_model->product_in_purchase_id;

            $product_in_purchase_model = \App\Models\ProductInPurchaseModel::find($order_model->product_in_purchase_id);
            \App\Helpers\Assistant::assertModel($product_in_purchase_model);

            $current_max_price = $product_in_purchase_model->getMaxPrice();

            $order_collection->product_price = $current_max_price;
            $order_collection->total_price = number_format(\App\Helpers\OrdersHelper::getTotalPrice($current_max_price, $order_model->amount), 2);

            $order_collection->product_name = $product_in_purchase_model->product->name;
            $order_collection->product_alias = $product_in_purchase_model->alias();

            $orders_collections_arr[] = $order_collection;
        }

        return $orders_collections_arr;
    }
}