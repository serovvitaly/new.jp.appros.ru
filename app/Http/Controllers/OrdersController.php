<?php namespace App\Http\Controllers;


class OrdersController extends PrivateController
{

    public function getIndex()
    {

        $purchases_ids_arr = \App\Helpers\OrdersHelper::getPurchasesIdsArrByUserId($this->user->id);

        /**
         * TODO: заменить на \App\Helpers\OrdersHelper::getOrdersCollectionsByPurchaseIdAndByUserId
         */
        $orders_models_arr_by_purchases_ids_arr = \App\Helpers\OrdersHelper::getOrdersModelsArrByPurchasesIdsArrAndByUserId($this->user->id, $purchases_ids_arr);

        return view('orders.index', [
            'purchases_ids_arr' => $purchases_ids_arr,
            'orders_models_arr_by_purchases_ids_arr' => $orders_models_arr_by_purchases_ids_arr
        ]);
    }

}