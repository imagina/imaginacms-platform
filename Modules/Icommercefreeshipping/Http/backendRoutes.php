<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('/icommercefreeshipping')->group(function (Router $router) {
    $router->bind('icommercefreeshipping', function ($id) {
        return app('Modules\Icommercefreeshipping\Repositories\IcommerceFreeshippingRepository')->find($id);
    });
    $router->get('icommercefreeshippings', [
        'as' => 'admin.icommercefreeshipping.icommercefreeshipping.index',
        'uses' => 'IcommerceFreeshippingController@index',
        'middleware' => 'can:icommercefreeshipping.icommercefreeshippings.index',
    ]);
    $router->get('icommercefreeshippings/create', [
        'as' => 'admin.icommercefreeshipping.icommercefreeshipping.create',
        'uses' => 'IcommerceFreeshippingController@create',
        'middleware' => 'can:icommercefreeshipping.icommercefreeshippings.create',
    ]);
    $router->post('icommercefreeshippings', [
        'as' => 'admin.icommercefreeshipping.icommercefreeshipping.store',
        'uses' => 'IcommerceFreeshippingController@store',
        'middleware' => 'can:icommercefreeshipping.icommercefreeshippings.create',
    ]);
    $router->get('icommercefreeshippings/{icommercefreeshipping}/edit', [
        'as' => 'admin.icommercefreeshipping.icommercefreeshipping.edit',
        'uses' => 'IcommerceFreeshippingController@edit',
        'middleware' => 'can:icommercefreeshipping.icommercefreeshippings.edit',
    ]);
    $router->put('icommercefreeshippings/{icommercefreeshipping}', [
        'as' => 'admin.icommercefreeshipping.icommercefreeshipping.update',
        'uses' => 'IcommerceFreeshippingController@update',
        'middleware' => 'can:icommercefreeshipping.icommercefreeshippings.edit',
    ]);
    $router->delete('icommercefreeshippings/{icommercefreeshipping}', [
        'as' => 'admin.icommercefreeshipping.icommercefreeshipping.destroy',
        'uses' => 'IcommerceFreeshippingController@destroy',
        'middleware' => 'can:icommercefreeshipping.icommercefreeshippings.destroy',
    ]);
    // append
});
