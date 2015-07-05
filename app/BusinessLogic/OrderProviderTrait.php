<?php

namespace App\BusinessLogic;


trait OrderProviderTrait
{
    /**
     * Создание заказа
     * @param array $fields
     * @return Order
     * @throws \Exception
     */
    public function makeOrder(array $fields)
    {
        \App\Helpers\Assistant::assertUserAsJson($this->user);

        $validator = \Validator::make($fields, [
            'purchase_id' => 'required|integer',
            'product_id' => 'required|integer',
            'amount' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $order = $this->user->makeOrder($fields['purchase_id'], $fields['product_id'], $fields['amount']);

        return $order;
    }

    /**
     * Возвращает модель заказа
     * @param $order_id
     * @return mixed
     */
    public function getOrder($order_id)
    {
        return \App\BusinessLogic\Models\Order::find($order_id);
    }

    /**
     * Возвращает список заказов
     * @return mixed
     */
    public function getOrdersList()
    {
        return \App\BusinessLogic\Models\Order::take(50)->get();
    }

    /**
     * Изменение заказа
     * @param $order_id
     * @param array $fields
     * @return mixed
     */
    public function updateOrder($order_id, array $fields)
    {
        \App\Helpers\Assistant::assertUserAsJson($this->user);

        $validator = \Validator::make($fields, [
            'amount' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $order = $this->user->updateAmountOrder($order_id, $fields['amount']);

        if (!$order) {
            return ['Order not found'];
        }

        return $order;
    }

    /**
     * Удаление заказа
     * @param $order_id
     * @return bool
     */
    public function deleteOrder($order_id)
    {
        \App\Helpers\Assistant::assertUserAsJson($this->user);

        $order = $this->user->orders()->find($order_id);

        if (!$order) {
            return false;
        }

        $order->delete();

        return true;
    }
}