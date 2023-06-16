<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::group(['prefix' => '/qreable'], function (Router $router) {
    $router->bind('qr', function ($id) {
        return app('Modules\Qreable\Repositories\QrRepository')->find($id);
    });
    $router->get('locations', [
        'as' => 'admin.qreable.qr.index',
        'uses' => 'QrController@index',
        'middleware' => 'can:qreable.locations.index',
    ]);
    $router->get('locations/create', [
        'as' => 'admin.qreable.qr.create',
        'uses' => 'QrController@create',
        'middleware' => 'can:qreable.locations.create',
    ]);
    $router->post('locations', [
        'as' => 'admin.qreable.qr.store',
        'uses' => 'QrController@store',
        'middleware' => 'can:qreable.locations.create',
    ]);
    $router->get('locations/{qr}/edit', [
        'as' => 'admin.qreable.qr.edit',
        'uses' => 'QrController@edit',
        'middleware' => 'can:qreable.locations.edit',
    ]);
    $router->put('locations/{qr}', [
        'as' => 'admin.qreable.qr.update',
        'uses' => 'QrController@update',
        'middleware' => 'can:qreable.locations.edit',
    ]);
    $router->delete('locations/{qr}', [
        'as' => 'admin.qreable.qr.destroy',
        'uses' => 'QrController@destroy',
        'middleware' => 'can:qreable.locations.destroy',
    ]);
    // append
});
