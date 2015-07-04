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
        $validator = \Validator::make($fields, [
            'purchase_id' => 'required|integer',
            'product_id' => 'required|integer',
            'amount' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $fields['user_id'] = $this->user->id;

        $fields[] = $fields['amount'];

        $sql = 'INSERT INTO orders (purchase_id, product_id, amount, user_id) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE amount = amount + ?';

        \DB::insert($sql, [
            $fields['purchase_id'],
            $fields['product_id'],
            $fields['amount'],
            $fields['user_id'],
            $fields['amount']
        ]);

        $order_id = \DB::connection()->getPdo()->lastInsertId();

        //$order = \App\BusinessLogic\Models\Order::create($fields);

        return ['id' => $order_id];
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
        $validator = \Validator::make($fields, [
            'amount' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // TODO: сделать проверку прав на изменение заказа

        $order = \App\BusinessLogic\Models\Order::find($order_id);

        if (!$order) {
            return ['Order not found'];
        }

        $order->amount = $fields['amount'];

        $order->save();

        return $order;
    }

    /**
     * Удаление заказа
     * @param $order_id
     * @return bool
     */
    public function deleteOrder($order_id)
    {
        $order = $this->user->orders()->find($order_id);

        if (!$order) {
            return false;
        }

        $order->delete();

        return true;
    }
}