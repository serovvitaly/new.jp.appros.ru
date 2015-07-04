<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return app('BusinessLogic')->getPurchasesList();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // TODO: сделать проверку прав на создание закупки

        return app('BusinessLogic')->makePurchase($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $purchase_id
     * @return Response
     */
    public function show($purchase_id)
    {
        // TODO: сделать проверку прав на просмотр закупки

        $purchase = app('BusinessLogic')->getPurchase($purchase_id);

        if (!$purchase) {
            return ['Purchase not found'];
        }

        return $purchase;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $purchase_id
     * @param Request $request
     * @return Response
     */
    public function update($purchase_id, Request $request)
    {
        // TODO: сделать проверку прав на изменение закупки

        return app('BusinessLogic')->updatePurchase($purchase_id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $purchase_id
     * @return Response
     */
    public function destroy($purchase_id)
    {
        // TODO: сделать проверку прав на удаление закупки

        return (string) app('BusinessLogic')->deletePurchase($purchase_id);
    }
}
