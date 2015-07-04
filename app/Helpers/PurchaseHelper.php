<?php namespace App\Helpers;


class PurchaseHelper {

    public static function getProductsAvailableForSale($limit = 40, $offset = 0)
    {
        $products_in_purchase_models = \App\Models\ProductInPurchaseModel::paginate(30);

        return $products_in_purchase_models;
    }

    /**
     * Возвращает коллекцию данных для построения "Таблицы цен"
     * @param $product_id
     * @param $purchase_id
     * @return array
     */
    public static function getPricingGridMixForProduct($product_id, $purchase_id)
    {

        /**
         * @var $product \App\Models\ProductModel
         * @var $purchase \App\Models\PurchaseModel
         */
        $product = \App\Models\ProductModel::find($product_id);
        $purchase = \App\Models\PurchaseModel::find($purchase_id);

        $pricing_grid_columns = $purchase->getPricingGridColumns()->get();

        $columns_ids_arr = [];
        foreach ($pricing_grid_columns as $column) {
            $columns_ids_arr[] = $column->id;
        }

        $product_prices = $product->prices($columns_ids_arr);
        $product_prices_unsorted = [];
        foreach ($product_prices as $product_price) {
            $product_prices_unsorted[$product_price->column_id] = $product_price->price;
        }

        $rows = [];

        foreach ($pricing_grid_columns as $column) {

            $rows[] = [
                'title' => $column->column_title,
                'expiry_date' => date('d.m.Y H:i'),
                'price' => $product_prices_unsorted[$column->id],
            ];
        }


        return $rows;
    }

    /**
     * Возвращает ID продукта по псевдониму(URL)
     * @param $alias
     * @return int|null
     */
    public static function getProductIdByAlias($alias)
    {
        $matches = [];

        preg_match('/^(\d+)_/', $alias, $matches);

        if (count($matches) != 2) {
            return null;
        }

        return (int) $matches[1];
    }

    /**
     * Возвращает ID закупки по псевдониму(URL)
     * @param $alias
     * @return int|null
     */
    public static function getPurchaseIdByAlias($alias)
    {
        $matches = [];

        preg_match('/_(\d+)$/', $alias, $matches);

        if (count($matches) != 2) {
            return null;
        }

        return (int) $matches[1];
    }

}