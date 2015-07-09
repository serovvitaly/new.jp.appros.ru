<?php namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;

class SuppliersController extends SellerController {

    public function getIndex()
    {
        $suppliers_models_arr = $this->user->suppliers()->paginate(20);

        return view('seller.suppliers.index', ['suppliers_models_arr' => $suppliers_models_arr]);
    }

    public function getShow($supplier_id)
    {
        $supplier_model = $this->user->suppliers()->find($supplier_id);
        \App\Helpers\Assistant::assertModel($supplier_model);

        return view('seller.suppliers.supplier', ['supplier_model' => $supplier_model]);
    }

    public function getProducts($supplier_id)
    {
        $supplier_model = $this->user->suppliers()->find($supplier_id);
        \App\Helpers\Assistant::assertModel($supplier_model);

        $products_models_arr = $supplier_model->products()->paginate(50);

        return view('seller.suppliers.products', ['supplier_model' => $supplier_model, 'goods_models_arr' => $products_models_arr]);
    }

    public function getPricingGrids($supplier_id)
    {
        $supplier_model = $this->user->suppliers()->find($supplier_id);
        \App\Helpers\Assistant::assertModel($supplier_model);

        $products_models_arr = $supplier_model->products()->paginate(50);

        return view('seller.suppliers.pricing-grids', ['supplier_model' => $supplier_model, 'goods_models_arr' => $products_models_arr]);
    }

    public function postSave(Request $request)
    {
        $post_fields_arr = $request->all();

        $validator = \Validator::make($post_fields_arr, [
            'name' => 'required|max:100',
            'description' => 'max:1000',
        ]);

        if ($validator->fails()) {
            return 'Невалидные данные';
        }

        $post_fields_arr['user_id'] = $this->user->id;

        if (isset($post_fields_arr['id'])) {
            $widget_model = \App\Models\PricingGridModel::find($post_fields_arr['id']);

            if (!$widget_model) {
                return 'Ошибка: нет виджета с таким ID - ' . $post_fields_arr['id'];
            }

            $widget_model->name        = $post_fields_arr['name'];
            $widget_model->description = $post_fields_arr['description'];

            $widget_model->save();
        } else {
            \App\Models\SupplierModel::create($post_fields_arr);
        }

        return redirect('/seller/suppliers');
    }

}