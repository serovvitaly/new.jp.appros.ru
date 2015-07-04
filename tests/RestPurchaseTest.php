<?php

/**
 * Тестирование Закупок
 * @author Vitaly Serov
 */
class RestPurchaseTest extends TestCase
{
    /**
     * Создание закупки
     * @param $name
     * @param $description
     * @return array
     */
    public function testMakePurchase($name = 1, $description = 1)
    {
        $name = 'Test Purchase';
        $description = 'Description for Test Purchase';
        $minimum_total_amount = "52000.00";
        $expiration_time = date('Y-m-d H:i:00', time() + 3600 * 24 * 7);
        $pricing_grid_id = '14';

        \Session::start();

        $user = \App\User::find(8);

        $response = $this->actingAs($user)
            ->post('/rest/purchase', [
                '_token' => \Session::token(),
                'name' => $name,
                'description' => $description,
                'minimum_total_amount' => $minimum_total_amount,
                'expiration_time' => $expiration_time,
                'pricing_grid_id' => $pricing_grid_id,
            ],[
                'X-Requested-With' => 'XMLHttpRequest'
            ])
            ->seeJson([
                'name' => $name,
                'description' => $description,
                'minimum_total_amount' => $minimum_total_amount,
                'expiration_time' => $expiration_time,
                'pricing_grid_id' => $pricing_grid_id,
                'user_id' => $user->id
            ])
            ->response;

        $this->assertResponseOk();

        return json_decode($response->content());
    }

    /**
     * Просмотр закупки
     * @depends testMakePurchase
     * @param $purchase_data
     */
    public function testShowPurchase($purchase_data)
    {
        $purchase_id = $purchase_data->id;

        $this->assertNotEmpty($purchase_id);

        $url = '/rest/purchase/' . $purchase_id;

        $purchase_data->id = strval($purchase_data->id);

        $this->get($url, ['X-Requested-With' => 'XMLHttpRequest'])->seeJson( (array) $purchase_data );

        $this->assertResponseOk();

        return $purchase_id;
    }

    /**
     * Изменение закупки
     * @depends testShowPurchase
     * @param $purchase_id
     */
    public function testUpdatePurchase($purchase_id)
    {
        $this->assertNotEmpty($purchase_id);

        $url = '/rest/purchase/' . $purchase_id;

        $new_name = 'New Test Purchase';
        $new_description = 'New description for Test Purchase';
        $new_minimum_total_amount = "35000.00";
        $new_expiration_time = date('Y-m-d H:i:00', time() + 3600 * 24 * 5);
        $new_pricing_grid_id = '6';

        \Session::start();

        $user = \App\User::find(8);

        $this->actingAs($user)
            ->patch($url, [
                '_token' => \Session::token(),
                'name' => $new_name,
                'description' => $new_description,
                'minimum_total_amount' => $new_minimum_total_amount,
                'expiration_time' => $new_expiration_time,
                'pricing_grid_id' => $new_pricing_grid_id,
            ], [
                'X-Requested-With' => 'XMLHttpRequest'
            ]);

        $this->assertResponseOk();

        $this->get($url, ['X-Requested-With' => 'XMLHttpRequest'])->seeJson([
            'id' => strval($purchase_id),
            'name' => $new_name,
            'description' => $new_description,
            'minimum_total_amount' => $new_minimum_total_amount,
            'expiration_time' => $new_expiration_time,
            'pricing_grid_id' => $new_pricing_grid_id,
        ]);

        $this->assertResponseOk();

        return $purchase_id;
    }

    /**
     * Удаление закупки
     * @depends testUpdatePurchase
     * @param $purchase_id
     */
    public function testDeletePurchase($purchase_id)
    {
        $this->assertNotEmpty($purchase_id);

        $url = '/rest/purchase/' . $purchase_id;

        \Session::start();

        $user = \App\User::find(8);

        $this->actingAs($user)->delete($url, ['_token' => \Session::token()], ['X-Requested-With' => 'XMLHttpRequest'])->see(1);

        $this->assertResponseOk();

        $this->get($url, ['X-Requested-With' => 'XMLHttpRequest'])->seeJson(['Purchase not found']);
    }
}