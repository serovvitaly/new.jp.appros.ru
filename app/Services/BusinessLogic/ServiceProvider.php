<?php

namespace App\Services\BusinessLogic;


use App\Services\BusinessLogic\Models\ProductInPurchase;

class ServiceProvider
{
    use \App\Services\BusinessLogic\ProductProviderTrait,
        \App\Services\BusinessLogic\PurchaseProviderTrait,
        \App\Services\BusinessLogic\ProductInPurchaseProviderTrait,
        \App\Services\BusinessLogic\PaymentTransactionProviderTrait,
        \App\Services\BusinessLogic\OrderProviderTrait;

    protected $app = null;

    protected $user = null;

    public function __construct($app)
    {
        $this->app = $app;

        $this->user = \Auth::user();
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getProductsInPurchases()
    {
        $filter = \Input::get('filter', []);

        $search_query = '';
        $category_id = 0;

        if (array_key_exists('query', $filter)) {
            $search_query = trim($filter['query']);
        }
        if (array_key_exists('category', $filter)) {
            $category_id = intval($filter['category']);
        }

        $matches_ids = [];

        if ($category_id) {

            $products_ids_arr = \App\Helpers\ProjectHelper::getProductsIdsArrByTagId($category_id);

            $matches_ids = array_merge($matches_ids, $products_ids_arr);

        }

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

            $matches_ids = array_merge($matches_ids, array_keys($res[0]['matches']));
        }

        $products_in_purchases_query = \DB::table('products_in_purchase')->select('*');

        if (!empty($matches_ids)) {
            $products_in_purchases_query = $products_in_purchases_query->whereIn('product_id', $matches_ids);
        }

        $products_in_purchases_arr = $products_in_purchases_query->take(12)->get();

        if (empty($products_in_purchases_arr)) {
            return [];
        }

        $products_arr = [];

        foreach ($products_in_purchases_arr as $product_in_purchase_mix) {

            $product = \App\BusinessLogic\Models\Product::find($product_in_purchase_mix->product_id);

            $purchase = \App\BusinessLogic\Models\Purchase::find($product_in_purchase_mix->purchase_id);

            $products_arr[] = new ProductInPurchase($product, $purchase);
        }

        return $products_arr;
    }
}