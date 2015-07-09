<?php namespace App\Http\Controllers;


class CatalogController extends Controller {

    public function getIndex()
    {
        $products_in_purchases = app('BusinessLogic')->getProductsInPurchases();

        $output = '';

        foreach ($products_in_purchases as $product_in_purchase) {
            $output .= view('product.list_item', [
                'product_in_purchase' => $product_in_purchase
            ])->render();
        }

        return $output;
    }

}