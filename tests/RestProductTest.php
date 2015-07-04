<?php

/**
 * Тестирование Продуктов
 * @author Vitaly Serov
 */
class RestProductTest extends TestCase
{
    /**
     * Создание продукта
     * @param $name
     * @param $description
     * @return array
     */
    public function testMakeProduct($name = 1, $description = 1)
    {
        $name = 'Test Product';
        $description = 'Description for Test Product';

        \Session::start();

        $user = \App\User::find(8);

        $response = $this->actingAs($user)
            ->post('/rest/product', [
                '_token' => \Session::token(),
                'name' => $name,
                'description' => $description
            ],[
                'X-Requested-With' => 'XMLHttpRequest'
            ])
            ->seeJson([
                'name' => $name,
                'description' => $description,
                'user_id' => $user->id
            ])
            ->response;

        $this->assertResponseOk();

        return json_decode($response->content());
    }

    /**
     * Просмотр продукта
     * @depends testMakeProduct
     * @param $product_data
     */
    public function testShowProduct($product_data)
    {
        $product_id = $product_data->id;

        $this->assertNotEmpty($product_id);

        $url = '/rest/product/' . $product_id;

        $product_data->id = strval($product_data->id);

        $this->get($url, ['X-Requested-With' => 'XMLHttpRequest'])->seeJson( (array) $product_data );

        $this->assertResponseOk();

        return $product_id;
    }

    /**
     * Изменение продукта
     * @depends testShowProduct
     * @param $product_id
     */
    public function testUpdateProduct($product_id)
    {
        $this->assertNotEmpty($product_id);

        $url = '/rest/product/' . $product_id;

        $new_name = 'New Test Product';
        $new_description = 'New description for Test Product';

        \Session::start();

        $user = \App\User::find(8);

        $this->actingAs($user)
            ->patch($url, [
                '_token' => \Session::token(),
                'name' => $new_name,
                'description' => $new_description
            ], [
                'X-Requested-With' => 'XMLHttpRequest'
            ]);

        $this->assertResponseOk();

        $this->get($url, ['X-Requested-With' => 'XMLHttpRequest'])->seeJson([
            'id' => strval($product_id),
            'name' => $new_name,
            'description' => $new_description
        ]);

        $this->assertResponseOk();

        return $product_id;
    }

    /**
     * Удаление продукта
     * @depends testUpdateProduct
     * @param $product_id
     */
    public function testDeleteProduct($product_id)
    {
        $this->assertNotEmpty($product_id);

        $url = '/rest/product/' . $product_id;

        \Session::start();

        $user = \App\User::find(8);

        $this->actingAs($user)->delete($url, ['_token' => \Session::token()], ['X-Requested-With' => 'XMLHttpRequest'])->see(1);

        $this->assertResponseOk();

        $this->get($url, ['X-Requested-With' => 'XMLHttpRequest'])->seeJson(['Product not found']);
    }
}