<?php

namespace App\Services\BusinessLogic;


trait PurchaseProviderTrait
{
    /**
     * Создание закупки
     * @param array $fields
     * @return Purchase
     * @throws \Exception
     */
    public function makePurchase(array $fields)
    {
        $validator = \Validator::make($fields, [
            'name' => 'required|max:255',
            'description' => 'max:5000',
            'minimum_total_amount' => 'required|numeric',
            'pricing_grid_id' => 'required|integer',
            'expiration_time' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $fields['user_id'] = $this->user->id;

        $purchase = \App\BusinessLogic\Models\Purchase::create($fields);

        return $purchase;
    }

    /**
     * Возвращает модель закупки
     * @param $purchase_id
     * @return Purchase
     */
    public function getPurchase($purchase_id)
    {
        return \App\BusinessLogic\Models\Purchase::find($purchase_id);
    }

    /**
     * Возвращает список закупок
     * @return mixed
     */
    public function getPurchasesList()
    {
        return \App\BusinessLogic\Models\Purchase::take(50)->get();
    }

    /**
     * Изменение закупки
     * @param $purchase_id
     * @param array $fields
     * @return mixed
     */
    public function updatePurchase($purchase_id, array $fields)
    {
        $validator = \Validator::make($fields, [
            'name' => 'required|max:255',
            'description' => 'max:5000',
            'minimum_total_amount' => 'required|numeric',
            'pricing_grid_id' => 'required|integer',
            'expiration_time' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // TODO: сделать проверку прав на изменение закупки

        $purchase = \App\BusinessLogic\Models\Purchase::find($purchase_id);

        if (!$purchase) {
            return ['Purchase not found'];
        }

        $purchase->name = $fields['name'];
        $purchase->description = $fields['description'];
        $purchase->minimum_total_amount = $fields['minimum_total_amount'];
        $purchase->pricing_grid_id = $fields['pricing_grid_id'];
        $purchase->expiration_time = $fields['expiration_time'];

        $purchase->save();

        return $purchase;
    }

    /**
     * Удаление закупки
     * @param $purchase_id
     * @return bool
     */
    public function deletePurchase($purchase_id)
    {
        $purchase = $this->user->purchases()->find($purchase_id);

        if (!$purchase) {
            return false;
        }

        $purchase->delete();

        return true;
    }
}