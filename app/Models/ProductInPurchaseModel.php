<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInPurchaseModel extends Model {

    protected $table = 'products_in_purchase';

    protected $fillable = ['purchase_id', 'product_id', 'product_data'];

    public static function findByProductIdAndByPurchaseId($product_id, $purchase_id)
    {
        return self::where('product_id', '=', $product_id)->where('purchase_id', '=', $purchase_id)->first();
    }

    public static function create(array $attributes)
    {
        $purchase_id = array_get($attributes, 'purchase_id');
        $product_id = array_get($attributes, 'product_id');

        if (!$purchase_id or !$product_id) {
            return null;
        }

        $first = \App\Models\ProductInPurchaseModel::where('purchase_id', '=', $purchase_id)
                    ->where('product_id', '=', $product_id)
                    ->first();

        if ($first) {
            return null;
        }

        return parent::create($attributes);
    }

    public function product()
    {
        return $this->belongsTo('\App\Models\ProductModel');
    }

    public function purchase()
    {
        return $this->belongsTo('\App\Models\PurchaseModel');
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

    public function alias()
    {
        return 'product-' . $this->product->id . '_' . $this->purchase->id;
    }

    public function stars()
    {
        return rand(1,5);
    }

    public function getFullData()
    {
        return json_decode($this->product_data);
    }

    public function getProductId()
    {
        return $this->product->id;
    }

    public function getPurchaseId()
    {
        return $this->purchase->id;
    }

    /**
     * Возвращает количество комментариев
     * @return int
     */
    public function getCommentsCount()
    {
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
            ->where('product_id', '=', $this->getProductId())
            ->where('column_id', '=', $max_pricing_grid_column_id)
            ->first();

        if (!$price_obj) {
            \App\Helpers\Assistant::exception("Не указана цена для продукта {$this->getProductId()} в колонке {$max_pricing_grid_column_id}");
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
            ->where('product_id', '=', $this->getProductId())
            ->where('column_id', '=', $current_max_pricing_grid_column_id)
            ->first();

        if (!$price_obj) {
            \App\Helpers\Assistant::exception("Не указана цена для продукта {$this->getProductId()} в колонке {$current_max_pricing_grid_column_id}");
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
            ->where('target_id', '=', $this->id)
            ->where('target_type', '=', \App\Models\AttendanceCounterModel::TARGET_TYPE_PRODUCT_IN_PURCHASE)
            ->count();
    }
}