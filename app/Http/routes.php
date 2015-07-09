<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('product-{alias}', 'ProductController@getProduct');

Route::get('admin', 'DashboardController@getIndex');

Route::get('/', 'HomeController@getIndex');

Route::get('home', 'HomeController@getIndex');

Route::get('zakupka/{id}', 'PurchasesController@getPurchase');

Route::get('/media/images/{width_height}/{file_name}', 'Seller\MediaController@getImage');

Route::resource('user', '\App\Http\Controllers\UserController');

Route::controllers([
    'auth' => '\App\Http\Controllers\Auth\AuthController',
    'password' => '\App\Http\Controllers\Auth\PasswordController',
    //'user' => '\App\Http\Controllers\UserController',
    'catalog' => 'CatalogController',
    //'orders' => 'OrdersController',
]);

/**
 * RESTful роуты
 */
Route::group(['prefix' => 'rest'], function()
{
    Route::resource('pip', 'Rest\ProductInPurchaseController');
    Route::resource('product', 'Rest\ProductController');
    Route::resource('purchase', 'Rest\PurchaseController');
    Route::resource('payment-transaction', 'Rest\PaymentTransactionController');
    //Route::resource('attribute', 'Rest\AttributeController');
    //Route::resource('catalog', 'Rest\CatalogController');
    //Route::resource('pricing-grid', 'Rest\PricingGridController');
    //Route::resource('pricing-grid-column', 'Rest\PricingGridColumnController');
    //Route::resource('media', 'Rest\MediaController');
    //Route::resource('basket', 'Rest\BasketController');
    //Route::resource('token', 'Rest\TokenController');
    //Route::resource('comment', 'Rest\CommentController');
    Route::resource('order', 'Rest\OrderController');
    //Route::resource('grid', 'Rest\GridController');
    Route::resource('user', 'Rest\UserController');
});


/**
 * Раздел "Продавцы"
 */
Route::group(['prefix' => 'seller', 'middleware' => 'seller'], function()
{
    Route::post('media/upload', 'Seller\MediaController@postUpload');
    Route::get('media/remove/{id}', 'Seller\MediaController@getRemove');
    Route::get('media/image/{file_name}/{width?}/{height?}', 'Seller\MediaController@getImage');

    Route::get('attribute-group/{id}', 'Seller\AttributesController@getGroup');
    Route::get('product/{id}', 'Seller\ProductsController@getProduct');
    Route::get('product/delete/{id}', 'Seller\ProductsController@getDelete');

    Route::get('suppliers/{id}', 'Seller\SuppliersController@getShow');
    Route::get('purchases/{id}', 'Seller\PurchasesController@getShow');

    Route::controllers([
        'auth' => 'Seller\AuthController',
        'suppliers' => 'Seller\SuppliersController',
        'products' => 'Seller\ProductsController',
        'pricing-grids' => 'Seller\PricingGridsController',
        'purchases' => 'Seller\PurchasesController',
        'prices' => 'Seller\PricesController',
        'attributes' => 'Seller\AttributesController',
        '/' => 'Seller\IndexController',
    ]);
});