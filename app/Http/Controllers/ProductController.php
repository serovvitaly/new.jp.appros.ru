<?php namespace App\Http\Controllers;


class ProductController extends Controller {

    public function getProduct($alias = null)
    {
        if (empty($alias)) {
            return response(view('errors.product_404'), 404);
        }

        $product_id = \App\Helpers\PurchaseHelper::getProductIdByAlias($alias);
        $product_model = \App\Models\ProductModel::find($product_id);

        $purchase_id = \App\Helpers\PurchaseHelper::getPurchaseIdByAlias($alias);
        $purchase_model = \App\Models\PurchaseModel::find($purchase_id);

        $product_in_purchase = \App\Models\ProductInPurchaseModel::findByProductIdAndByPurchaseId($product_id, $purchase_id);

        \App\Models\AttendanceCounterModel::enrol($product_in_purchase->id, \App\Models\AttendanceCounterModel::TARGET_TYPE_PRODUCT_IN_PURCHASE);

        if (!$product_model or !$purchase_model) {
            return response(view('errors.product_404'), 404);
        }

        return view('product.card', [
            'product_in_purchase' => $product_in_purchase,
            'product' => $product_model,
            'purchase' => $purchase_model
        ]);
    }

}