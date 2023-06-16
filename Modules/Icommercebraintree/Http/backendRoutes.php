<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('/icommercebraintree')->group(function (Router $router) {
    $router->bind('icommercebraintree', function ($id) {
        return app('Modules\Icommercebraintree\Repositories\IcommerceBraintreeRepository')->find($id);
    });
    $router->get('icommercebraintrees', [
        'as' => 'admin.icommercebraintree.icommercebraintree.index',
        'uses' => 'IcommerceBraintreeController@index',
        'middleware' => 'can:icommercebraintree.icommercebraintrees.index',
    ]);
    $router->get('icommercebraintrees/create', [
        'as' => 'admin.icommercebraintree.icommercebraintree.create',
        'uses' => 'IcommerceBraintreeController@create',
        'middleware' => 'can:icommercebraintree.icommercebraintrees.create',
    ]);
    $router->post('icommercebraintrees', [
        'as' => 'admin.icommercebraintree.icommercebraintree.store',
        'uses' => 'IcommerceBraintreeController@store',
        'middleware' => 'can:icommercebraintree.icommercebraintrees.create',
    ]);
    $router->get('icommercebraintrees/{icommercebraintree}/edit', [
        'as' => 'admin.icommercebraintree.icommercebraintree.edit',
        'uses' => 'IcommerceBraintreeController@edit',
        'middleware' => 'can:icommercebraintree.icommercebraintrees.edit',
    ]);
    $router->put('icommercebraintrees/{id}', [
        'as' => 'admin.icommercebraintree.icommercebraintree.update',
        'uses' => 'IcommerceBraintreeController@update',
        'middleware' => 'can:icommercebraintree.icommercebraintrees.edit',
    ]);
    $router->delete('icommercebraintrees/{icommercebraintree}', [
        'as' => 'admin.icommercebraintree.icommercebraintree.destroy',
        'uses' => 'IcommerceBraintreeController@destroy',
        'middleware' => 'can:icommercebraintree.icommercebraintrees.destroy',
    ]);
    // append
});
