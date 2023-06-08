<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/icommercexpay'], function (Router $router) {
    $router->bind('icommercexpay', function ($id) {
        return app('Modules\Icommercexpay\Repositories\IcommerceXpayRepository')->find($id);
    });
    $router->get('icommercexpays', [
        'as' => 'admin.icommercexpay.icommercexpay.index',
        'uses' => 'IcommerceXpayController@index',
        'middleware' => 'can:icommercexpay.icommercexpays.index'
    ]);
    $router->get('icommercexpays/create', [
        'as' => 'admin.icommercexpay.icommercexpay.create',
        'uses' => 'IcommerceXpayController@create',
        'middleware' => 'can:icommercexpay.icommercexpays.create'
    ]);
    $router->post('icommercexpays', [
        'as' => 'admin.icommercexpay.icommercexpay.store',
        'uses' => 'IcommerceXpayController@store',
        'middleware' => 'can:icommercexpay.icommercexpays.create'
    ]);
    $router->get('icommercexpays/{icommercexpay}/edit', [
        'as' => 'admin.icommercexpay.icommercexpay.edit',
        'uses' => 'IcommerceXpayController@edit',
        'middleware' => 'can:icommercexpay.icommercexpays.edit'
    ]);
    $router->put('icommercexpays/{id}', [
        'as' => 'admin.icommercexpay.icommercexpay.update',
        'uses' => 'IcommerceXpayController@update',
        'middleware' => 'can:icommercexpay.icommercexpays.edit'
    ]);
    $router->delete('icommercexpays/{icommercexpay}', [
        'as' => 'admin.icommercexpay.icommercexpay.destroy',
        'uses' => 'IcommerceXpayController@destroy',
        'middleware' => 'can:icommercexpay.icommercexpays.destroy'
    ]);
// append

});
