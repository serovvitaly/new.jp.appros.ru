<?php namespace App\Helpers;


class ProjectHelper {

    const PRICES_TABLE_NAME = 'prices';

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

}