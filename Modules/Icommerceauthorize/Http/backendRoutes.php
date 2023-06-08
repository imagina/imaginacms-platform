<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/icommerceauthorize'], function (Router $router) {
    $router->bind('icommerceauthorize', function ($id) {
        return app('Modules\Icommerceauthorize\Repositories\IcommerceAuthorizeRepository')->find($id);
    });
    $router->get('icommerceauthorizes', [
        'as' => 'admin.icommerceauthorize.icommerceauthorize.index',
        'uses' => 'IcommerceAuthorizeController@index',
        'middleware' => 'can:icommerceauthorize.icommerceauthorizes.index'
    ]);
    $router->get('icommerceauthorizes/create', [
        'as' => 'admin.icommerceauthorize.icommerceauthorize.create',
        'uses' => 'IcommerceAuthorizeController@create',
        'middleware' => 'can:icommerceauthorize.icommerceauthorizes.create'
    ]);
    $router->post('icommerceauthorizes', [
        'as' => 'admin.icommerceauthorize.icommerceauthorize.store',
        'uses' => 'IcommerceAuthorizeController@store',
        'middleware' => 'can:icommerceauthorize.icommerceauthorizes.create'
    ]);
    $router->get('icommerceauthorizes/{icommerceauthorize}/edit', [
        'as' => 'admin.icommerceauthorize.icommerceauthorize.edit',
        'uses' => 'IcommerceAuthorizeController@edit',
        'middleware' => 'can:icommerceauthorize.icommerceauthorizes.edit'
    ]);
    $router->put('icommerceauthorizes/{id}', [
        'as' => 'admin.icommerceauthorize.icommerceauthorize.update',
        'uses' => 'IcommerceAuthorizeController@update',
        'middleware' => 'can:icommerceauthorize.icommerceauthorizes.edit'
    ]);
    $router->delete('icommerceauthorizes/{icommerceauthorize}', [
        'as' => 'admin.icommerceauthorize.icommerceauthorize.destroy',
        'uses' => 'IcommerceAuthorizeController@destroy',
        'middleware' => 'can:icommerceauthorize.icommerceauthorizes.destroy'
    ]);
// append

});
