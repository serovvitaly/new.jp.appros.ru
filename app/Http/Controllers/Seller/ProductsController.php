<?php namespace App\Http\Controllers\Seller;

use App\Http\Requests;
use Illuminate\Http\Request;

class ProductsController extends SellerController {

    public function getIndex()
    {
        $goods_models_arr = $this->user->products()->paginate(50);

        return view('seller.products.index', ['goods_models_arr' => $goods_models_arr, 'user' => $this->user]);
    }

    /**
     * Возвращает данные о продукте
     * @param $id
     * @return json
     */
    public function getProduct($id)
    {
        /**
         * @var $product \App\Models\ProductModel
         */
        $product = \App\Models\ProductModel::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Продукт не найден'
            ]);
        }

        $product_mix = $product->toArray();

        $attributes_mix = [];
        $attributes = $product->attributes()->get();
        if ($attributes->count()) {
            foreach ($attributes as $attribute) {
                $attributes_mix['attr_' . $attribute->attribute_id] = $attribute->value;
            }
        }
        $product_mix['attributes'] = $attributes_mix;

        $categories_ids = [];
        $categories = $product->categories()->get(['id']);
        if ($categories) {
            foreach ($categories as $category) {
                $categories_ids[] = intval($category->id);
            }
        }
        $product_mix['categories_ids'] = $categories_ids;

        $prices = $product->prices();

        $product_mix['prices'] = $prices;

        $product_mix['images'] = $product->media('image')->get();

        return response()->json($product_mix);
    }

    /**
     * Создание или сохранение продукта
     * @param Request $request
     * @return string
     */
    public function postSave(Request $request)
    {
        $post_fields_arr = $request->all();

        $validator = \Validator::make($post_fields_arr, [
            'name' => 'required|max:255',
            'description' => 'max:5000',
        ]);

        if ($validator->fails()) {
            return 'Невалидные данные';
        }

        $post_fields_arr['user_id'] = $this->user->id;
        $post_fields_arr['supplier_id'] = \Input::get('supplier_id');

        $product_id = 0;
        if (isset($post_fields_arr['id']) and intval($post_fields_arr['id']) > 0) {
            $product_id = intval($post_fields_arr['id']);
        }

        if ($product_id) {
            $product = \App\Models\ProductModel::find($post_fields_arr['id']);

            if (!$product) {
                return 'Ошибка: нет виджета с таким ID - ' . $post_fields_arr['id'];
            }

            $product->name        = $post_fields_arr['name'];
            $product->description = $post_fields_arr['description'];

            $product->save();
        } else {
            $product = \App\Models\ProductModel::create($post_fields_arr);
        }

        if (isset($post_fields_arr['categories_ids']) and !empty($post_fields_arr['categories_ids'])) {
            $product->categories()->attach($post_fields_arr['categories_ids']);
        }

        if (isset($post_fields_arr['attributes']) and !empty($post_fields_arr['attributes'])) {
            foreach ($post_fields_arr['attributes'] as $attribute_code => $attribute_value) {

                $attribute_id = intval(substr($attribute_code, 5));

                echo substr($attribute_code, 5);

                $attribute = \App\Models\AttributeValueModel::where('product_id', '=', $product->id)->where('attribute_id', '=', $attribute_id)->first();

                if ($attribute) {
                    $attribute->value = $attribute_value;
                    $attribute->save();
                } else {
                    \App\Models\AttributeValueModel::create([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute_id,
                        'value' => $attribute_value
                    ]);
                }
            }
        }

        if (isset($post_fields_arr['prices']) and !empty($post_fields_arr['prices'])) {
            foreach ($post_fields_arr['prices'] as $price_code => $price_value) {
                \App\Models\PricingGridModel::setPriceByPriceCode($price_code, $price_value, $product->id);
            }
        }
    }

    public function getDelete($id)
    {
        $product = \App\Models\ProductModel::find($id);

        if ($product) {
            $product->delete();
        }
    }

    /**
     * Создание или сохранение категории
     * @param Request $request
     * @return string
     */
    public function postSaveCategory(Request $request)
    {
        $post_fields_arr = $request->all();

        /**
         * @var $category \Illuminate\Database\Eloquent\Model
         */
        if (isset($post_fields_arr['id'])) {
            $category = \App\Models\CatalogModel::find($post_fields_arr['id']);

            if (!$category) {
                return 'Ошибка: нет категории с таким ID - ' . $post_fields_arr['id'];
            }

            $category->name       = $post_fields_arr['name'];
            $category->parent_id  = $post_fields_arr['parent_id'];
            $category->project_id = $post_fields_arr['project_id'];

            $category->save();
        } else {
            \App\Models\CatalogModel::create($post_fields_arr);
        }

        return redirect('/seller/products');
    }
}
