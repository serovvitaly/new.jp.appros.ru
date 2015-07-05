<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductInPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $search_query = \Input::get('q');

        $matches_ids = [];

        if ($search_query) {
            $sphinx = \Sphinx\SphinxClient::create();
            $sphinx->setServer('127.0.0.1', 3312);
            $sphinx->setMatchMode(\Sphinx\SphinxClient::SPH_MATCH_ANY);
            $sphinx->setSortMode(\Sphinx\SphinxClient::SPH_SORT_RELEVANCE);
            $sphinx->setFieldWeights(array ('name' => 20, 'description' => 10));
            $sphinx->addQuery($search_query, '*');
            $res = $sphinx->runQueries();
            if (!$res or !array_key_exists('matches', $res[0])) {
                return [];
            }

            $matches_ids = array_keys($res[0]['matches']);
        }

        $products_in_purchases_arr = \DB::table('products_in_purchase')->select('*')->take(10);

        if (!empty($matches_ids)) {
            $products_in_purchases_arr = $products_in_purchases_arr->whereIn('product_id', $matches_ids);
        }

        $products_in_purchases_arr = $products_in_purchases_arr->get();

        if (empty($products_in_purchases_arr)) {
            return [];
        }

        $products_ins_arr = [];

        foreach ($products_in_purchases_arr as $product_in_purchase_mix) {

            $product = \App\BusinessLogic\Models\Product::find($product_in_purchase_mix->product_id);

            $purchase = \App\BusinessLogic\Models\Purchase::find($product_in_purchase_mix->purchase_id);

            $products_ins_arr[$product_in_purchase_mix->purchase_id . '_' . $product_in_purchase_mix->product_id] = json_decode( new \App\BusinessLogic\ProductInPurchase($product, $purchase) );
        }

        return $products_ins_arr;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
