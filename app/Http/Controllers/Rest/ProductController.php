<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return app('BusinessLogic')->getProductsList();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // TODO: сделать проверку прав на создание продукта

        return app('BusinessLogic')->makeProduct($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $product_id
     * @return Response
     */
    public function show($product_id)
    {
        // TODO: сделать проверку прав на просмотр продукта

        $product = app('BusinessLogic')->getProduct($product_id);

        if (!$product) {
            return ['Product not found'];
        }

        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $product_id
     * @param Request $request
     * @return Response
     */
    public function update($product_id, Request $request)
    {
        // TODO: сделать проверку прав на изменение продукта

        return app('BusinessLogic')->updateProduct($product_id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $product_id
     * @return Response
     */
    public function destroy($product_id)
    {
        // TODO: сделать проверку прав на удаление продукта

        return (string) app('BusinessLogic')->deleteProduct($product_id);
    }
}
