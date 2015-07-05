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
            ])
            ->response;

        $this->assertResponseOk();

        //\Storage::disk('local')->put('tests/makeProduct_'.$this->getDataSetAsString().'.json', $response->content());

        $order_mix = json_decode($response->content());

        $order_id = $order_mix->id;

        $order = \App\BusinessLogic\Models\Order::find($order_id);

        $this->assertNotNull($order);

        $this->assertEquals($purchase_id, $order->purchase_id);
        $this->assertEquals($product_id, $order->product_id);
        $this->assertEquals($user->id, $order->user_id);

        //\Storage::disk('local')->put('tests/makeProduct.html', $response->content());
    }

    public function testDeleteOrder()
    {
        $order_id = 9;

        $url = '/rest/product/' . $order_id;

        \Session::start();

        $user = \App\User::find(1);

        $this->actingAs($user)->delete($url, ['_token' => \Session::token()], ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseOk();

        $this->get($url, ['X-Requested-With' => 'XMLHttpRequest'])->seeJson(['id' => strval($order_id)]);
    }

    public function getOrdersDataArr()
    {
        $orders_data_arr = [];

        for ($i = 1; $i <= 500; $i++) {
            $orders_data_arr[] = [
                'purchase_id' => 5,
                'product_id' => rand(21400, 21600),
                'amount' => rand(1,3),
            ];
        }

        return $orders_data_arr;
    }
}
