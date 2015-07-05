<?php namespace App\Http\Controllers;


class CatalogController extends Controller {

    public function getIndex()
    {
        return view('tezo/index');

        $offset = intval(\Input::get('start', 0));
        $limit = intval(\Input::get('limit', 40));

        $products_in_purchases = app('BusinessLogic')->getProductsInPurchases();

        return view('catalog.index', ['products_in_purchases' => $products_in_purchases]);
    }

}