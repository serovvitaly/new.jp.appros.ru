<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель "Закупка"
 * @package App\Models
 */
class PurchaseModel extends Model {

    public $table = 'purchases';

    protected $current_max_pricing_grid_column_id = null;

    protected $orders_total_sum = 0;

    protected $fillable = ['user_id', 'name', 'description', 'pricing_grid_id', 'expiration_time', 'supplier_id', 'minimum_total_amount'];

    /**
     * "Продавец"
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seller()
    {
        return $this->belongsTo('\App\User', 'user_id');
    }

    /**
     * "Поставщик товаров"
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo('\App\Models\SupplierModel');
    }

    /**
     * Продукты в закупке
     * @return \App\BusinessLogic\Models\Product
     */
	public function products()
    {
        return $this->belongsToMany('\App\BusinessLogic\Models\Product', 'products_in_purchase', 'purchase_id', 'product_id');
    }

    /**
     * Прикрепляет продукт к закупке
     * @param $product_model_or_id - ID продукта или модель продукта
     * @return bool
     */
    public function appendProduct($product_model_or_id)
    {
        if ($product_model_or_id instanceof \App\BusinessLogic\Models\Product) {
            $this->products()->attach($product_model_or_id->id);
            return true;
        }

        if (is_numeric($product_model_or_id)) {
            $this->products()->attach($product_model_or_id);
            return true;
        }

        return false;
    }

    /**
     * Открепляет продукт от закупки
     * @param $product_model_or_id - ID продукта или модель продукта
     * @return bool
     */
    public function removeProduct($product_model_or_id)
    {
        if ($product_model_or_id instanceof \App\BusinessLogic\Models\Product) {
            $this->products()->detach($product_model_or_id->id);
            return true;
        }

        if (is_numeric($product_model_or_id)) {
            $this->products()->detach($product_model_or_id);
            return true;
        }

        return false;
    }

    public function setPricingGridColumns($beginning_column_id, $final_column_id = null)
    {
        $pricing_grid_columns_ids_arr = [];

        /**
         * @var $beginning_column_model \App\Models\PricingGridColumnModel
         */
        $beginning_column_model = \App\Models\PricingGridColumnModel::find($beginning_column_id);
        \App\Helpers\Assistant::assertModel($beginning_column_model, 'Не найдено модели PricingGridColumnModel с идентификатором ID#' . $beginning_column_id);

        $pricing_grid_model = $beginning_column_model->pricing_grid();
        \App\Helpers\Assistant::assertModel($pricing_grid_model, 'Не найдено связанной модели PricingGridModel с моделью PricingGridColumnModel ID#' . $beginning_column_id);

        $pricing_grid_columns_ids_arr[] = $beginning_column_model->id;

        $final_column_id = intval($final_column_id);

        if ($final_column_id) {
            $pricing_grid_columns_models = $pricing_grid_model->columns();
            \App\Helpers\Assistant::assertNotEmpty($pricing_grid_columns_models, 'Модель PricingGridModel ID#' . $pricing_grid_model->id . ' не имеет ценовых колонок');

            foreach ($pricing_grid_columns_models as $pricing_grid_column_model) {
                $pricing_grid_columns_ids_arr[] = $pricing_grid_column_model->id;
                if ($pricing_grid_column_model->id = $final_column_id) {
                    break;
                }
            }

            \App\Helpers\Assistant::assert(in_array($final_column_id, $pricing_grid_columns_ids_arr));
        }

        $this->pricing_grid_columns()->attach($pricing_grid_columns_ids_arr);

        return true;
    }

    /**
     * Ценовая сетка закупки
     * @return \App\Models\PricingGridModel
     */
    public function pricing_grid()
    {
        return $this->belongsTo('\App\Models\PricingGridModel');
    }

    /**
     * Возвращает колонки Ценовой сетки, привязанной к данной закупке
     * @param string $order_by
     * @return mixed
     */
    public function getPricingGridColumns($order_by = 'asc')
    {
        $pricing_grid_columns = \App\Models\PricingGridColumnModel::where('pricing_grid_id', '=', $this->pricing_grid_id)->orderBy('min_sum', $order_by);

        return $pricing_grid_columns;
    }

    /**
     * Возвращает структуру цен по ценовым колонкам для продукта
     * @deprecated
     * @param $product_id
     * @return array
     */
    public function getPricingGridMixForProduct($product_id)
    {
        $headers = [];
        $prices = [];

        $pricing_grid_id = $this->pricing_grid->id;

        /**
         * TODO: здень неправильно запрашивается ценовая колонка, нужно определять еще саму закупку
         */
        $pricing_grid_columns = \App\Models\PricingGridColumnModel::where('pricing_grid_id', '=', $pricing_grid_id)->orderBy('min_sum')->get();

        $columns_ids_arr = [];

        foreach ($pricing_grid_columns as $column) {
            $headers[] = $column->column_title;
            $columns_ids_arr[] = $column->id;
        }

        /**
         * TODO: здень нужно выбирать только продукт для данной закупки, т.е. \App\Models\ProductInPurchaseModel, через $this->products()
         */
        $product = \App\BusinessLogic\Models\Product::find($product_id);
        $product_prices = $product->prices($columns_ids_arr);

        $product_prices_unsorted = [];

        foreach ($product_prices as $product_price) {
            $product_prices_unsorted[$product_price->column_id] = $product_price->price;
        }

        foreach ($pricing_grid_columns as $column) {
            $prices[] = $product_prices_unsorted[$column->id];
        }

        return [
            'headers' => $headers,
            'prices' => $prices
        ];
    }

    /**
     * Возвращает матрицу общих сумм всех "Заказов" для всех колонок,
     * где "Ключ" - Id ценовой колонки, "Значение" - общаю саумма заказов с учетом этой ценовой колонки
     * @return array
     */
    protected function getOrdersTotalSumMatrix()
    {
        $orders_models_arr = $this->orders()->get();

        if (!$orders_models_arr) {
            return [];
        }

        $pricing_grid_columns_models_arr = $this->getPricingGridColumns()->get();

        $pricing_grid_columns_ids_arr = [];
        foreach ($pricing_grid_columns_models_arr as $pricing_grid_column_model) {
            $pricing_grid_columns_ids_arr[] = $pricing_grid_column_model->id;
        }

        $all_orders_products_ids_arr = $this->getAllOrdersProductsIdsArr();

        $products_prices_arr = [];

        /**
         * @var $product_model \App\BusinessLogic\Models\Product
         */
        foreach ($all_orders_products_ids_arr as $product_id) {
            $product_model = \App\BusinessLogic\Models\Product::find($product_id);
            \App\Helpers\Assistant::assertModel($product_model);

            $products_prices_arr[$product_id] = $product_model->getPricesArr($pricing_grid_columns_ids_arr);
        }

        $total_sum_arr = [];

        $orders_mix_arr = [];
        foreach ($orders_models_arr as $order_model) {

            $orders_mix_arr[$order_model->id] = [
                'product_id' => $order_model->product_id,
                'amount' => $order_model->amount
            ];

        }

        foreach ($pricing_grid_columns_ids_arr as $pricing_grid_column_id) {

            $total_sum = 0;

            foreach ($orders_mix_arr as $order_mix) {
                $total_sum += ($order_mix['amount'] * $products_prices_arr[$order_mix['product_id']][$pricing_grid_column_id]);
            }

            $total_sum_arr[$pricing_grid_column_id] = doubleval($total_sum);
        }

        return $total_sum_arr;
    }

    /**
     * Вычисляет текущую максимальную колонку и общую сумму заказов
     */
    protected function calculateCurrentMaxPricingGridColumnIdAndOrdersTotalSum()
    {
        $orders_total_sum_matrix = $this->getOrdersTotalSumMatrix();

        $pricing_grid_columns_models_arr = $this->getPricingGridColumns()->get();

        if (!$pricing_grid_columns_models_arr) {
            \App\Helpers\Assistant::exception("Не назначено ни одной ценовой колонки для закупки {$this->id}");
        }

        /**
         * @var $pricing_grid_column_model \App\Models\PricingGridColumnModel
         */
        foreach ($pricing_grid_columns_models_arr as $pricing_grid_column_model) {

            if ($pricing_grid_column_model->maxSumInclusive()) {
                if ($orders_total_sum_matrix[$pricing_grid_column_model->id] > $pricing_grid_column_model->maxSum()) {
                    continue;
                }
            } else {
                if ($orders_total_sum_matrix[$pricing_grid_column_model->id] >= $pricing_grid_column_model->maxSum()) {
                    continue;
                }
            }

            $this->current_max_pricing_grid_column_id = $pricing_grid_column_model->id;

            $this->orders_total_sum = $orders_total_sum_matrix[$pricing_grid_column_model->id];

            break;
        }
    }

    /**
     * Возвращает ID текущей максимальной колонки
     * @param $orders_total_sum
     * @return int
     */
    public function getCurrentMaxPricingGridColumnId()
    {
        if (!$this->current_max_pricing_grid_column_id) {
            $this->calculateCurrentMaxPricingGridColumnIdAndOrdersTotalSum();
        }

        return $this->current_max_pricing_grid_column_id;
    }

    /**
     * Возвращает общую сумму заказов
     * @return float
     */
    public function getOrdersTotalSum()
    {
        if (!$this->orders_total_sum) {
            $this->calculateCurrentMaxPricingGridColumnIdAndOrdersTotalSum();
        }

        return $this->orders_total_sum;
    }

    /**
     * Возвращает коллекцию моделей "Заказов"
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('\App\BusinessLogic\Models\Order', 'purchase_id');
    }

    /**
     * Возвращает массив ID всех продуктов в заказах этой закупки
     * @return array
     */
    public function getAllOrdersProductsIdsArr()
    {
        $products_arr = \DB::table('orders')->select('product_id')->groupBy('product_id')->get();

        if (!$products_arr) {
            return [];
        }

        $products_ids_arr = [];

        foreach ($products_arr as $product_obj) {
            $products_ids_arr[] = $product_obj->product_id;
        }

        return $products_ids_arr;
    }

    /**
     * Возвращает количество участников(покупателей) закупки
     */
    public function getParticipantsCount()
    {
        return $this->orders()->groupBy('user_id')->get()->count();
    }

    /**
     * Возвращает процент завершенности закупки
     */
    public function getCompletedOnPercents()
    {
        if ($this->minimum_total_amount <= 0) {
            return 0;
        }

        return intval( $this->getOrdersTotalSum() * 100 / $this->minimum_total_amount );
    }
}
