<?php

/**
 * Тестирование Заказа
 * @author Vitaly Serov
 */
class RestOrderTest extends TestCase
{
    /**
     * Создание Заказа
     * @dataProvider getOrdersDataArr
     * @param $purchase_id
     * @param $product_id
     * @param $amount
     * @return array
     */
    public function testMakeOrder($purchase_id, $product_id, $amount)
    {
        \Session::start();

        $user = \App\User::find(8);

        $response = $this->actingAs($user)
            ->post('/rest/order', [
                '_token' => \Session::token(),
                'purchase_id' => $purchase_id,
                'product_id' => $product_id,
                'amount' => $amount,
            ],[
                'X-Requested-With' => 'XMLHttpRequest'
            ])/*
            ->seeJson([
                'purchase_id' => $purchase_id,
                'product_id' => $product_id,
                'amount' => $amount,
                'user_id' => $user->id
            ])*/
            ->response;

        //\Storage::disk('local')->put('tests/makeProduct.html', $response->content());

        $this->assertResponseOk();

        //return json_decode($response->content());
    }

    public function getOrdersDataArr()
    {
        $orders_data_arr = [];

        for ($i = 1; $i <= 3; $i++) {
            $orders_data_arr[] = [
                'purchase_id' => rand(1, 20),
                'product_id' => rand(1000, 2000),
                'amount' => rand(1,4),
            ];
        }

        return $orders_data_arr;
    }
}
