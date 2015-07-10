<?php namespace App\Services\BusinessLogic\Models;


use App\BusinessLogic\Models\Product;
use App\BusinessLogic\Models\Purchase;

class ProductInPurchase
{
    protected $product = null;

    protected $purchase = null;

    public function __construct(Product $product, Purchase $purchase)
    {
        $this->product = $product;

        $this->purchase = $purchase;
    }

    public function getId()
    {
        return $this->product->id;
    }

    public function getPurchase()
    {
        return $this->purchase;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function alias()
    {
        return 'product-' . $this->product->id . '_' . $this->purchase->id;
    }

    /**
     * Возвращает количество комментариев
     * @return int
     */
    public function getCommentsCount()
    {
        return 0;

        return \App\Models\CommentModel::where('target_id', '=', $this->id)
            ->where('target_type', '=', \App\Models\CommentModel::TARGET_TYPE_PRODUCT_IN_PURCHASE)
            ->count();
    }

    /**
     * Возвращает максимальную цену
     * @return float
     */
    public function getMaxPrice()
    {
        $pricing_grid_columns = $this->purchase->getPricingGridColumns()->get();

        $max_pricing_grid_column_id = $pricing_grid_columns[0]->id;

        $price_obj = \DB::table('prices')
            ->where('product_id', '=', $this->getProduct()->id)
            ->where('column_id', '=', $max_pricing_grid_column_id)
            ->first();

        if (!$price_obj) {
            \App\Helpers\Assistant::exception("Не указана цена для продукта {$this->getProduct()->id} в колонке {$max_pricing_grid_column_id}");
            return 0;
        }

        return $price_obj->price;
    }

    /**
     * Возвращает текущую максимальную цену
     * @return float
     */
    public function getCurrentMaxPrice()
    {
        $current_max_pricing_grid_column_id = $this->purchase->getCurrentMaxPricingGridColumnId();

        $price_obj = \DB::table('prices')
            ->where('product_id', '=', $this->getProduct()->id)
            ->where('column_id', '=', $current_max_pricing_grid_column_id)
            ->first();

        if (!$price_obj) {
            \App\Helpers\Assistant::exception("Не указана цена для продукта {$this->getProduct()->id} в колонке {$current_max_pricing_grid_column_id}");
            return 0;
        }

        return $price_obj->price;
    }

    /**
     * Возвращает количество посещений
     * @return int
     */
    public function getAttendance()
    {
        return \DB::table('attendance_counter')
            //->where('target_id', '=', $this->id)
            ->where('target_type', '=', \App\Models\AttendanceCounterModel::TARGET_TYPE_PRODUCT_IN_PURCHASE)
            ->count();
    }

    public function images()
    {
        return $this->product->image();

        $full_data = $this->getFullData();

        if (property_exists($full_data, 'images')) {
            return $full_data->images;
        }

        return [];
    }

    public function getFirstImageFileName()
    {
        return $this->product->image();

        $images = $this->images();

        if (empty($images)){
            return null;
        }

        return $images[0]->file_name;
    }
}