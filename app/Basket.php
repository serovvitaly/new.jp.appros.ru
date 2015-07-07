<?php namespace App;

class Basket {

    const TABLE_PRODUCTS_IN_BASKETS = 'orders';

    protected $user_id = null;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getPurchasesQuantity()
    {
        $purchases_quantity = \DB::table(self::TABLE_PRODUCTS_IN_BASKETS)
            ->where('user_id', '=', $this->user_id)
            ->sum('amount');

        return $purchases_quantity;
    }

    /**
     * @param \App\Models\ProductInPurchaseModel $product_in_purchase_model
     * @param int $amount
     */
    public function addProduct(\Illuminate\Database\Eloquent\Model $product_in_purchase_model, $amount = 1)
    {
        // \App\Helpers\Assistant::assertModel($product_in_purchase_model);

        $products_in_baskets = \DB::table(self::TABLE_PRODUCTS_IN_BASKETS)
            ->select('*')
            ->where('user_id', '=', $this->user_id)
            ->where('product_in_purchase_id', '=', $product_in_purchase_model->id)
            ->first();

        if ($products_in_baskets) {

            $new_amount = $products_in_baskets->amount + $amount;

            \DB::table(self::TABLE_PRODUCTS_IN_BASKETS)
                ->where('user_id', '=', $this->user_id)
                ->where('product_in_purchase_id', '=', $product_in_purchase_model->id)
                ->update(['amount' => $new_amount]);
        } else {

            \DB::table(self::TABLE_PRODUCTS_IN_BASKETS)->insert([
                'user_id' => $this->user_id,
                'product_in_purchase_id' => $product_in_purchase_model->id,
                'product_id' => $product_in_purchase_model->getProductId(),
                'purchase_id' => $product_in_purchase_model->getPurchaseId(),
                'amount' => $amount
            ]);
        }
    }

}