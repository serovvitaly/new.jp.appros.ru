<?php namespace App\Http\Controllers;


class ExtGeneratorController extends Controller {

    public function getComponent($alias)
    {
        $alias_mix = [];

        preg_match('/([\d\w]+)\/([\d\w]+)\.js/', $alias, $alias_mix);

        if (count($alias_mix) != 3) {
            return;
        }

        $class_name = $alias_mix[2];

        $model_full_name = $this->getModelFullName($class_name);
        if (!$model_full_name) {
            $model_full_name = $this->getModelFullName($class_name . 'Model');
        }

        switch (strtolower($alias_mix[1])) {
            case 'store':
                $content = view('ext.data.Store', ['model_name' => $class_name]);
                break;
            case 'treestore':
                $content = view('ext.data.TreeStore', ['model_name' => $class_name]);
                break;
            case 'grid':

                $grid_columns = [];

                if ($model_full_name) {
                    $model = new $model_full_name;

                    if (property_exists($model, 'grid_columns')) {
                        $grid_columns = $model->grid_columns;
                    }
                }

                $content = view('ext.grid.Panel', [
                    'class_name' => $class_name,
                    'columns' => $grid_columns
                ]);
                break;
            case 'tree':
                $content = view('ext.tree.Panel', [
                    'class_name' => $class_name,
                    //'columns' => $grid_columns
                ]);
                break;
            case 'model':

                $fields_str = '';

                if ($model_full_name) {
                    $model = new $model_full_name;

                    $column_listing = \Schema::getColumnListing($model->getTable());

                    $fields = array_diff($column_listing, $model->getHidden());

                    $fields_str = '"' . implode('","', $fields) . '"';
                }

                $content = view('ext.data.Model', ['model_name' => $class_name, 'fields' => $fields_str]);
                break;
            case 'treemodel':

                $fields_str = [];

                if ($model_full_name) {
                    $model = new $model_full_name;

                    $column_listing = \Schema::getColumnListing($model->getTable());

                    $fields = array_diff($column_listing, $model->getHidden());

                    if (property_exists($model, 'tree_text_field')) {
                        $fields[] = [
                            'name' => 'text',
                            'mapping' => $model->tree_text_field,
                        ];
                    }

                    $fields_str = json_encode($fields);
                }

                $content = view('ext.data.TreeModel', ['model_name' => $class_name, 'fields' => $fields_str]);
                break;
            case 'controller':
                //
                break;
        }

        return response($content, 200)->header('Content-Type', 'application/javascript');
    }


    public function restModel($model_name, $id = null)
    {
        $model_full_name = $this->getModelFullName($model_name);
        if (!$model_full_name) {
            $model_full_name = $this->getModelFullName($model_name . 'Model');
        }

        switch (strtolower(\Request::method())) {
            case 'get':

                $id = intval($id);

                if ($id) {

                    $model = $model_full_name::find($id);
                    $output_data = $model->toArray();
                    if (isset($model->attached_relations) and !empty($model->attached_relations)) {
                        foreach ($model->attached_relations as $relation) {
                            $output_data[$relation] = $model->$relation()->get();
                        }
                    }

                    return $output_data;
                }

                $page  = intval(\Input::get('page'));
                $start = intval(\Input::get('start', 0));
                $limit = intval(\Input::get('limit', 40));

                return $model_full_name::offset($start)->take($limit)->get();

            case 'post':

                $data_fields = \Input::all();

                $id = intval(\Input::get('id'));

                if ($id) {
                    $model = $model_full_name::find($id);
                    $model->update($data_fields);
                } else {
                    $model = $model_full_name::create($data_fields);
                }

                if (property_exists('attached_relations', $model)) {
                    foreach ($data_fields as $relation_name => $field_value) {
                        if (!in_array($relation_name, $model->attached_relations)) {
                            continue;
                        }
                        if (!method_exists($model, $relation_name)) {
                            continue;
                        }
                        if (!is_array($field_value) or empty($field_value)) {
                            continue;
                        }
                        $attached_items = [];
                        $detached_items = [];
                        foreach ($field_value as $key => $value) {
                            if ($value == 1) {
                                $attached_items[] = $key;
                            } else {
                                $detached_items[] = $key;
                            }
                        }
                        if (!empty($attached_items)) {
                            $model->$relation_name()->attach($attached_items);
                        }
                        if (!empty($detached_items)) {
                            $model->$relation_name()->detach($detached_items);
                        }

                    }
                }

                return ['success'=>true, 'model' => $model];

                break;

            case 'put':

                $id = intval(\Input::get('id'));

                if ($id) {
                    $model = $model_full_name::find($id);
                    if ($model) {
                        $model->update(\Input::all());
                    }
                }

                break;

            case 'delete':

                $id = intval(\Input::get('id'));

                if ($id) {
                    $model_full_name::destroy($id);
                }

                break;
        }
    }


    protected function getModelFullName($model_name)
    {
        $model_name = ucfirst(strtolower($model_name));

        $model_full_name = '\App\\' . $model_name;
        if (!class_exists($model_full_name)) {
            $model_full_name = '\App\Models\\' . $model_name;
            if (!class_exists($model_full_name)) {
                $model_full_name = null;
            }
        }

        return $model_full_name;
    }

}