<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return app('BusinessLogic')->getOrdersList();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // TODO: сделать проверку прав на создание заказа

        return app('BusinessLogic')->makeOrder($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $order_id
     * @return Response
     */
    public function show($order_id)
    {
        // TODO: сделать проверку прав на просмотр заказа

        $order = app('BusinessLogic')->getOrder($order_id);

        if (!$order) {
            return ['Order not found'];
        }

        return $order;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $order_id
     * @return Response
     */
    public function update($order_id, Request $request)
    {
        // TODO: сделать проверку прав на изменение заказа

        return app('BusinessLogic')->updateOrder($order_id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $order_id
     * @return Response
     */
    public function destroy($order_id)
    {
        // TODO: сделать проверку прав на удаление заказа

        return (string) app('BusinessLogic')->deleteOrder($order_id);
    }
}
