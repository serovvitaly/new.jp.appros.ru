<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingGridColumnModel extends Model {

	public $table = 'pricing_grids_columns';

    /**
     * Ценовая сетка колонки
     * @return \App\Models\PricingGridModel
     */
    public function pricing_grid()
    {
        return $this->belongsTo('\App\Models\PricingGridModel');
    }

    public function minSumInclusive()
    {
        return boolval($this->min_sum_inclusive);
    }

    public function maxSumInclusive()
    {
        return boolval($this->max_sum_inclusive);
    }

    public function minSum()
    {
        return doubleval($this->min_sum);
    }

    public function maxSum()
    {
        return doubleval($this->max_sum);
    }

}
