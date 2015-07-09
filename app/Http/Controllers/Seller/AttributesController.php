<?php namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;

class AttributesController extends SellerController {

    public function getIndex()
    {
        return view('seller.attributes.index');
    }

    public function postSaveGroup(Request $request)
    {
        $post_fields_arr = $request->all();

        $post_fields_arr['user_id'] = $this->user->id;

        /**
         * @var $attributes_group_model \Illuminate\Database\Eloquent\Model
         */
        if (isset($post_fields_arr['id'])) {
            $attributes_group_model = \App\Models\AttributesGroupModel::find($post_fields_arr['id']);

            if (!$attributes_group_model) {
                return 'Ошибка: нет категории с таким ID - ' . $post_fields_arr['id'];
            }

            $attributes_group_model->name       = $post_fields_arr['name'];

            $attributes_group_model->save();
        } else {
            \App\Models\AttributesGroupModel::create($post_fields_arr);
        }

        return redirect('/seller/attributes');
    }

    public function getGroup($group_id)
    {
        $attributes_group = \App\Models\AttributesGroupModel::find($group_id);

        if (!$attributes_group) {
            return 'Группа не найдена';
        }

        return view('seller.attributes.group', $attributes_group->toArray());
    }

    public function postSave(Request $request)
    {
        $post_fields_arr = $request->all();

        if (isset($post_fields_arr['id'])) {
            $widget_model = \App\Models\AttributeModel::find($post_fields_arr['id']);

            if (!$widget_model) {
                return 'Ошибка: нет виджета с таким ID - ' . $post_fields_arr['id'];
            }

            $widget_model->title              = $post_fields_arr['name'];
            $widget_model->name               = $post_fields_arr['name'];
            $widget_model->attribute_group_id = $post_fields_arr['attribute_group_id'];

            $widget_model->save();
        } else {
            \App\Models\AttributeModel::create($post_fields_arr);
        }

        return redirect('/seller/attribute-group/' . $post_fields_arr['attribute_group_id']);
    }
}