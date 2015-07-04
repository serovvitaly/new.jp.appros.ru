<?php namespace App\Models;

class CatalogModel extends NestedSets {

    public $table = 'nested_sets';

    protected $fillable = ['name', 'parent_id', 'project_id'];

    const ROOT_NESTED_SETS_ID = 1; // Корневой NS элемент для каталога товаров

    public function products()
    {
        return $this->belongsToMany('\App\Models\ProductModel', 'category_product', 'category_id', 'product_id');
    }

    public static function getRootNode()
    {
        return self::find(self::ROOT_NESTED_SETS_ID);
    }
}
