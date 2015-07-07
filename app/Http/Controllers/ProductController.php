<?php namespace App\Http\Controllers;


class ProductController extends Controller {

    public function getProduct($alias = null)
    {
        if (empty($alias)) {
            return response(view('errors.product_404'), 404);
        }

        $product_id = \App\Helpers\PurchaseHelper::getProductIdByAlias($alias);
        $product_model = \App\BusinessLogic\Models\Product::find($product_id);
        \App\Helpers\Assistant::assertModel($product_model);

        $purchase_id = \App\Helpers\PurchaseHelper::getPurchaseIdByAlias($alias);
        $purchase_model = \App\BusinessLogic\Models\Purchase::find($purchase_id);
        \App\Helpers\Assistant::assertModel($purchase_model);

        //$product_in_purchase = \App\Models\ProductInPurchaseModel::findByProductIdAndByPurchaseId($product_id, $purchase_id);
        $product_in_purchase = new \App\BusinessLogic\ProductInPurchase($product_model, $purchase_model);

    //    \App\Models\AttendanceCounterModel::enrol($product_in_purchase->id, \App\Models\AttendanceCounterModel::TARGET_TYPE_PRODUCT_IN_PURCHASE);

        if (!$product_model or !$purchase_model) {
            return response(view('errors.product_404'), 404);
        }

        return view('product.card', [
            'product_in_purchase' => $product_in_purchase
        ]);
    }

}