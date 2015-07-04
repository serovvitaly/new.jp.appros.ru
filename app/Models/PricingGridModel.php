<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingGridModel extends Model {

    public $table = 'pricing_grids';

    protected $fillable = ['user_id', 'name', 'description'];

    public static function getPricingGridsForCurrentUser()
    {
        $user = \Auth::user();

        if (!$user) {
            return [];
        }

        $result = self::where('user_id', '=', $user->id)->get(['id', 'name']);

        if (!$result) {
            return [];
        }

        return $result;
    }

    public function projects()
    {
        return $this->belongsToMany('\App\Models\ProjectModel', 'projects_pricing_grids', 'pricing_grid_id', 'project_id');
    }

    /**
     * Возвращает модели ценовых колонок в порядке роста цен, предварительно проверив корректность ценовых диапазонов
     * @return array
     * @throws \Exception
     */
    public function columns()
    {
        $columns_models = $this->hasMany('\App\Models\PricingGridColumnModel', 'pricing_grid_id')->orderBy('min_sum');

        if (!$columns_models->count()) {
            return [];
        }

        $columns_models_arr = [];

        $last_max_sum = 0;

        foreach ($columns_models->get() as $column_model) {

            $current_min_sum = doubleval($column_model->min_sum);
            $current_max_sum = doubleval($column_model->max_sum);

            if ($current_min_sum >= $current_max_sum) {
                \App\Helpers\Assistant::exception('Неверные значения цен (>=) в колонке ID#' . $column_model->id . ' для ценовой сетки ID#' . $this->id);
            }

            if ($current_min_sum != $last_max_sum) {
            //    \App\Helpers\Assistant::exception('Неверные значения цен (!=) в колонке ID#' . $column_model->id . ' для ценовой сетки ID#' . $this->id);
            }

            $last_max_sum = $current_max_sum;

            $columns_models_arr[] = $column_model;
        }

        return $columns_models_arr;
    }

    /**
     * Возвращает массив идентификаторов своих колонок
     * @return array
     */
    public function columnsIdsArr()
    {
        $columns = $this->columns()->get(['id']);

        if (empty($columns)) {
            return [];
        }

        $columns_ids_arr = [];

        foreach ($columns as $column) {
            $columns_ids_arr[] = $column->id;
        }

        return $columns_ids_arr;
    }

    /**
     * Устанавливает значение колонки цены
     * @param $price_code
     * @param $price_value
     * @param $product_id
     * @return void
     */
    public static function setPriceByPriceCode($price_code, $price_value, $product_id)
    {
        $matches = [];

        preg_match('/^col_([\d]+)$/', $price_code, $matches);

        if (count($matches) != 2) {
            return;
        }

        $price_value = str_replace(' ', '', $price_value);
        $price_value = str_replace(',', '.', $price_value);

        $column_id = intval($matches[1]);

        $column_price = \DB::table(\App\Helpers\ProjectHelper::PRICES_TABLE_NAME)->where('product_id', $product_id)->where('column_id', $column_id)->first();

        if ($column_price) {
            \DB::table(\App\Helpers\ProjectHelper::PRICES_TABLE_NAME)
                ->where('product_id', $product_id)
                ->where('column_id', $column_id)
                ->update([
                    'product_id' => $product_id,
                    'column_id' => $column_id,
                    'price' => floatval($price_value),
                ]);
        } else {
            \DB::table(\App\Helpers\ProjectHelper::PRICES_TABLE_NAME)
                ->insert([
                    'product_id' => $product_id,
                    'column_id' => $column_id,
                    'price' => floatval($price_value),
                ]);
        }
    }

}
