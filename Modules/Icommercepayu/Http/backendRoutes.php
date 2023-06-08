<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/icommercepayu'], function (Router $router) {
    $router->bind('icommercepayu', function ($id) {
        return app('Modules\Icommercepayu\Repositories\IcommercePayuRepository')->find($id);
    });
    $router->get('icommercepayus', [
        'as' => 'admin.icommercepayu.icommercepayu.index',
        'uses' => 'IcommercePayuController@index',
        'middleware' => 'can:icommercepayu.icommercepayus.index'
    ]);
    $router->get('icommercepayus/create', [
        'as' => 'admin.icommercepayu.icommercepayu.create',
        'uses' => 'IcommercePayuController@create',
        'middleware' => 'can:icommercepayu.icommercepayus.create'
    ]);
    $router->post('icommercepayus', [
        'as' => 'admin.icommercepayu.icommercepayu.store',
        'uses' => 'IcommercePayuController@store',
        'middleware' => 'can:icommercepayu.icommercepayus.create'
    ]);
    $router->get('icommercepayus/{icommercepayu}/edit', [
        'as' => 'admin.icommercepayu.icommercepayu.edit',
        'uses' => 'IcommercePayuController@edit',
        'middleware' => 'can:icommercepayu.icommercepayus.edit'
    ]);
    $router->put('icommercepayus/{id}', [
        'as' => 'admin.icommercepayu.icommercepayu.update',
        'uses' => 'IcommercePayuController@update',
        'middleware' => 'can:icommercepayu.icommercepayus.edit'
    ]);
    $router->delete('icommercepayus/{icommercepayu}', [
        'as' => 'admin.icommercepayu.icommercepayu.destroy',
        'uses' => 'IcommercePayuController@destroy',
        'middleware' => 'can:icommercepayu.icommercepayus.destroy'
    ]);
// append

});
