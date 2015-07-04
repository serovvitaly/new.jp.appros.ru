<?php

/**
 * Тестирование Пользователей
 * @author Vitaly Serov
 */
class RestUserTest extends TestCase
{
    /**
     * Регистрация пользователя
     * @internal param $name
     * @internal param $email
     * @internal param $password
     * @return array
     */
    public function testRegistrationUser()
    {
        $name = 'Test User';
        $email = 'test.user@mail.tv';
        $password = '123456';

        \Session::start();

        $response = $this->post('/rest/user', [
            '_token' => \Session::token(),
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password
        ],[
            'X-Requested-With' => 'XMLHttpRequest'
        ])
        ->seeJson([
            'name' => $name,
            'email' => $email
        ])->response;

        $this->assertResponseOk();

        return json_decode($response->content());
    }

    /**
     * Просмотр пользователя
     * @depends testRegistrationUser
     * @param $user_data
     */
    public function testShowUser($user_data)
    {
        $user_id = $user_data->id;

        $this->assertNotEmpty($user_id);

        $url = '/rest/user/' . $user_id;

        $user_data->id = strval($user_data->id);

        $this->get($url, ['X-Requested-With' => 'XMLHttpRequest'])->seeJson( (array) $user_data );

        $this->assertResponseOk();

        return $user_id;
    }

    /**
     * Изменение пользователя
     * @depends testShowUser
     * @param $user_id
     */
    public function testUpdateUser($user_id)
    {
        $this->assertNotEmpty($user_id);

        $url = '/rest/user/' . $user_id;

        $new_name = 'New Test User';

        $new_email = 'new.test.user@mail.tv';

        \Session::start();

        $this->patch($url, [
            '_token' => \Session::token(),
            'name' => $new_name,
            'email' => $new_email
        ], ['X-Requested-With' => 'XMLHttpRequest']);

        $this->assertResponseOk();

        $this->get($url, ['X-Requested-With' => 'XMLHttpRequest'])->seeJson([
            'id' => strval($user_id),
            'name' => $new_name,
            'email' => $new_email
        ]);

        $this->assertResponseOk();

        return $user_id;
    }

    /**
     * Удаление пользователя
     * @depends testUpdateUser
     * @param $user_id
     */
    public function testDeleteUser($user_id)
    {
        $this->assertNotEmpty($user_id);

        $url = '/rest/user/' . $user_id;

        \Session::start();

        $this->delete($url, ['_token' => \Session::token()], ['X-Requested-With' => 'XMLHttpRequest'])->see(1);

        $this->assertResponseOk();

        $this->get($url, ['X-Requested-With' => 'XMLHttpRequest'])->seeJson(['User not found']);

    }
}