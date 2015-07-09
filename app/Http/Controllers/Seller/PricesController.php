<?php namespace App\Http\Controllers\Seller;


class PricesController extends SellerController  {

    public function getIndex()
    {
        return view('seller.prices.index');
    }

}