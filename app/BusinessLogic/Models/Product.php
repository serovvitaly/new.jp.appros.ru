<?php

namespace App\BusinessLogic\Models;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'products';

    protected $fillable = ['user_id', 'name', 'description', 'supplier_id'];

    public function delete()
    {
        \DB::table(\App\Helpers\ProjectHelper::PRICES_TABLE_NAME)->where('product_id', '=', $this->id)->delete();
        \DB::table('category_product')->where('product_id', '=', $this->id)->delete();
        \DB::table('attribute_values')->where('product_id', '=', $this->id)->delete();

        $media = $this->media()->get();
        if ($media->count()) {
            foreach ($media as $media_object) {
                $media_object->delete();
            }
        }

        parent::delete();
    }

    public function purchases()
    {
        return $this->belongsToMany('\App\Models\PurchaseModel', 'products_in_purchase', 'product_id', 'purchase_id');
    }

    public function categories()
    {
        return $this->belongsToMany('\App\Models\CatalogModel', 'category_product', 'product_id', 'category_id');
    }

    public function attributes()
    {
        return $this->hasMany('\App\Models\AttributeValueModel', 'product_id');
    }

    public function media($type = null)
    {
        switch ($type) {
            case 'image':
                $images_ids_arr = [];
                break;
        }

        $media = $this->hasMany('\App\Models\MediaModel', 'product_id')->orderBy('position');

        if ($type) {
            //$media = $media->where('type', '=', $type);
        }

        return $media;
    }

    /**
     * Возвращает коллекцию цен данного продукта для связанных "Ценовых сеток",
     * @param array $columns_ids_arr
     * @return array
     */
    public function prices(array $columns_ids_arr = [])
    {
        $res = \DB::table(\App\Helpers\ProjectHelper::PRICES_TABLE_NAME)->where('product_id', $this->id);

        if (count($columns_ids_arr) === 1) {
            $res = $res->where('column_id', '=', $columns_ids_arr[0]);
        }
        elseif (!empty($columns_ids_arr)) {
            $res = $res->whereIn('column_id', $columns_ids_arr);
        }

        return $res->get(['column_id', 'price']);
    }

    /**
     * Возвращает коллекцию цен данного продукта для связанных "Ценовых сеток" в виде массива,
     * где "Ключ" - Id ценовой колонки, "Значение" - цена для этой ценовой колонки
     * @param array $columns_ids_arr
     * @return array
     */
    public function getPricesArr(array $columns_ids_arr = [])
    {
        $prices_objs_arr = $this->prices($columns_ids_arr);

        if (empty($prices_objs_arr)) {
            return [];
        }

        $prices_arr = [];

        foreach ($prices_objs_arr as $price_obj) {
            $prices_arr[intval($price_obj->column_id)] = doubleval($price_obj->price);
        }

        return $prices_arr;
    }

    /**
     * Возвращает значение атрибута, связанного с продуктом
     * @param $attribute_name
     * @return mixed
     */
    public function attr($attribute_name)
    {
        $attribute_name = trim($attribute_name);

        $attribute_obj = \App\Models\AttributeModel::where('name', '=', $attribute_name)->first(['id']);

        $attribute_value_obj = $this->attributes()->where('attribute_id', '=', $attribute_obj->id)->first(['value']);

        if (!$attribute_value_obj) {
            return null;
        }

        return $attribute_value_obj->value;
    }

    public function image()
    {
        $first_image = $this->media('image')->first();
        if ($first_image) {
            return $first_image->file_name;
        }
    }

    public function getFullData()
    {
        $product_obj = (object) $this->toArray();

        $attributes_arr = [];
        $attributes = $this->attributes()->get();
        if ($attributes->count()) {
            foreach ($attributes as $attribute) {
                $attributes_arr[$attribute->attribute_id] = $attribute->value;
            }
        }
        $product_obj->attributes = $attributes_arr;

        $categories_ids_arr = [];
        $categories = $this->categories()->get(['id']);
        if ($categories) {
            foreach ($categories as $category) {
                $categories_ids_arr[] = intval($category->id);
            }
        }
        $product_obj->categories_ids_arr = $categories_ids_arr;

        $product_obj->prices = $this->prices();

        $product_obj->images = $this->media('image')->get(['id', 'file_name']);

        return $product_obj;
    }

    /**
     * Возвращает цену данного продукта для указанной ценовой колонки
     * @param $pricing_grid_column_id
     * @return float
     */
    public function getPriceByColumnId($pricing_grid_column_id)
    {
        $price_objs_arr = $this->prices([$pricing_grid_column_id]);

        return doubleval($price_objs_arr[0]->price);
    }

    /**
     * Устанавливает занчение атрибута по его ID
     * @param $attribute_id
     * @param $value
     */
    public function setAttributeById($attribute_id, $value)
    {
        $attribute_value_model = $this->attributes()->where('attribute_id', '=', $attribute_id)->first();

        if (!$attribute_value_model) {
            $attribute_value_model = new \App\Models\AttributeValueModel;
            $attribute_value_model->product_id = $this->id;
            $attribute_value_model->attribute_id = $attribute_id;
        }

        $attribute_value_model->value = $value;

        $attribute_value_model->save();
    }

    /**
     * Устанавливает цену для ценовой колонки по ID колонки
     * @param $column_id
     * @param $price
     */
    public function setPriceByColumnId($column_id, $price)
    {
        $price = str_replace(',', '.', $price);

        $sql = "INSERT INTO `prices` (`product_id`, `column_id`, `price`) VALUES (?, ?, ?) ON duplicate KEY UPDATE `price` = VALUES(`price`)";

        \DB::insert($sql, [
            $this->id,
            $column_id,
            $price
        ]);
    }

    /**
     * Возвращает текущую максимальную цену
     * @param $purchase_id
     * @return float
     * @throws \Exception
     */
    public function getCurrentMaxPriceForPurchase($purchase_id)
    {
        $purchase = \App\BusinessLogic\Models\Purchase::find($purchase_id);
        \App\Helpers\Assistant::assertModel($purchase);

        $current_max_pricing_grid_column_id = $purchase->getCurrentMaxPricingGridColumnId();

        $price_obj = \DB::table('prices')
            ->where('product_id', '=', $this->id)
            ->where('column_id', '=', $current_max_pricing_grid_column_id)
            ->first();

        if (!$price_obj) {
            \App\Helpers\Assistant::exception("Не указана цена для продукта {$this->id} в колонке {$current_max_pricing_grid_column_id}");
            return 0;
        }

        return doubleval($price_obj->price);
    }
}