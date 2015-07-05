<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель "Поставщик товаров"
 * @package App\Models
 */
class SupplierModel extends Model {

    protected $table = 'suppliers';

    protected $fillable = ['user_id', 'name', 'description'];

    /**
     * Товары поставщика
     * @return \App\BusinessLogic\Models\Product
     */
    public function products()
    {
        return $this->hasMany('\App\BusinessLogic\Models\Product', 'supplier_id');
    }

    /**
     * Закупки
     * @return \App\BusinessLogic\Models\Product
     */
    public function purchases()
    {
        return $this->hasMany('\App\Models\PurchaseModel', 'supplier_id');
    }

    /**
     * Ценовые сетки
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pricing_grids()
    {
        return $this->belongsToMany('\App\Models\PricingGridModel', 'projects_pricing_grids', 'project_id', 'pricing_grid_id');
    }

}