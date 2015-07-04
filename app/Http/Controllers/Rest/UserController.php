<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return app('BusinessLogic')->getUsersArr();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        // TODO: сделать проверку прав на создание пользователя

        $user = \App\User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // TODO: сделать проверку прав на просмотр пользователя

        $user = app('BusinessLogic')->getUser($id);

        if (!$user) {
            return ['User not found'];
        }

        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param Request $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users'
        ]);

        // TODO: сделать проверку прав на изменение пользователя

        $user = \App\User::find($id);

        if (!$user) {
            return ['User not found'];
        }

        $user->name = $request->get('name');
        $user->email = $request->get('email');

        $user->save();

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        // TODO: сделать проверку прав на удаление пользователя

        return (string) \App\User::find($id)->delete();
    }
}
