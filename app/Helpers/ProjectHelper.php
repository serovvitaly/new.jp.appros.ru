<?php namespace App\Helpers;


class ProjectHelper {

    const PRICES_TABLE_NAME = 'prices';

    static $products_counts_by_tag_id_arr = [];

    public static function getDefaultAttributesGroupId()
    {
        return 1;
    }

    public static function getCategoriesByProjectId($project_id)
    {
        return \App\Models\CatalogModel::all();

        $user = \Auth::user();

        if (!$user) {
            return [];
        }

        /**
         * @var $project_model \App\Models\ProjectModel
         */
        $project_model = \App\Models\ProjectModel::where('id', '=', $project_id)->where('user_id', '=', $user->id)->first();

        if (!$project_model) {
            return [];
        }

        return $project_model->categories()->get();
    }


    public static function getAttributesGroups()
    {
        $user = \Auth::user();

        if (!$user) {
            return [];
        }

        $attributes_groups = \App\Models\AttributesGroupModel::where('user_id', '=', $user->id)->get();

        if (!$attributes_groups) {
            return [];
        }

        return $attributes_groups;
    }

    /**
     * Возвращает список ID Продуктов прявязанных к данному Тэгу
     * @param $tag_id
     * @return array
     */
    public static function getProductsIdsArrByTagId($tag_id)
    {
        $sql = 'SELECT product_id FROM products_tags WHERE tag_id = ?';

        $products_mixes_arr = \DB::select($sql, [$tag_id]);

        if (empty($products_mixes_arr)) {
            return [];
        }

        $products_ids_arr = [];
        foreach ($products_mixes_arr as $product_mix) {
            $products_ids_arr[] = $product_mix->product_id;
        }

        return $products_ids_arr;
    }


    public static function getAttributesByGroupId($group_id)
    {
        $user = \Auth::user();

        if (!$user) {
            return [];
        }

        $attributes = \App\Models\AttributeModel::where('attribute_group_id', '=', $group_id)->get();

        if (!$attributes) {
            return [];
        }

        return $attributes;
    }

    /**
     * Возвращает количество Продуктов, привязанных к данному Тэгу
     * @param $tag_id
     */
    public static function getProductsCountByTagId($tag_id)
    {
        if (empty(self::$products_counts_by_tag_id_arr)) {
            $sql = 'SELECT pt.tag_id, COUNT(pt.product_id) AS count FROM products_tags pt JOIN products_in_purchase pp ON pt.product_id = pp.product_id GROUP BY tag_id';
            $products_counts_mix = \DB::select($sql);
            if (empty($products_counts_mix)) {
                return;
            }
            foreach ($products_counts_mix as $products_count_mix) {
                self::$products_counts_by_tag_id_arr[intval($products_count_mix->tag_id)] = intval($products_count_mix->count);
            }
        }

        if (!array_key_exists($tag_id, self::$products_counts_by_tag_id_arr)) {
            return;
        }

        return self::$products_counts_by_tag_id_arr[$tag_id];


    }

}