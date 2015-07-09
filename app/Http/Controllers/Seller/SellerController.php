<?php namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;

abstract class SellerController extends Controller {

    protected $user = null;

    public function __construct()
    {
        //$this->middleware('seller');

        $this->user = \Auth::user();
    }

}