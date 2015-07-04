<?php

namespace App\BusinessLogic;


trait ProductProviderTrait
{
    /**
     * Создание продукта
     * @param array $fields
     * @return Product
     * @throws \Exception
     */
    public function makeProduct(array $fields)
    {
        $validator = \Validator::make($fields, [
            'name' => 'required|max:255',
            'description' => 'max:5000'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $fields['user_id'] = $this->user->id;

        $product = \App\BusinessLogic\Models\Product::create($fields);

        return $product;
    }

    /**
     * Возвращает модель продукта
     * @param $product_id
     * @return mixed
     */
    public function getProduct($product_id)
    {
        return \App\BusinessLogic\Models\Product::find($product_id);
    }

    /**
     * Возвращает список продуктов
     * @return mixed
     */
    public function getProductsList()
    {
        return \App\BusinessLogic\Models\Product::take(50)->get();
    }

    /**
     * Изменение продукта
     * @param $product_id
     * @param array $fields
     * @return mixed
     */
    public function updateProduct($product_id, array $fields)
    {
        $validator = \Validator::make($fields, [
            'name' => 'required|max:255',
            'description' => 'max:5000'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // TODO: сделать проверку прав на изменение продукта

        $product = \App\BusinessLogic\Models\Product::find($product_id);

        if (!$product) {
            return ['Product not found'];
        }

        $product->name = $fields['name'];
        $product->description = $fields['description'];

        $product->save();

        return $product;
    }

    /**
     * Удаление продукта
     * @param $product_id
     * @return bool
     */
    public function deleteProduct($product_id)
    {
        $product = $this->user->products()->find($product_id);

        if (!$product) {
            return false;
        }

        $product->delete();

        return true;
    }
}