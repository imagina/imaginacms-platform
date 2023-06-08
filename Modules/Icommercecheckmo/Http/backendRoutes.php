<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/icommercecheckmo'], function (Router $router) {
    $router->bind('icommercecheckmo', function ($id) {
        return app('Modules\Icommercecheckmo\Repositories\IcommerceCheckmoRepository')->find($id);
    });
    $router->get('icommercecheckmos', [
        'as' => 'admin.icommercecheckmo.icommercecheckmo.index',
        'uses' => 'IcommerceCheckmoController@index',
        'middleware' => 'can:icommercecheckmo.icommercecheckmos.index'
    ]);
    $router->get('icommercecheckmos/create', [
        'as' => 'admin.icommercecheckmo.icommercecheckmo.create',
        'uses' => 'IcommerceCheckmoController@create',
        'middleware' => 'can:icommercecheckmo.icommercecheckmos.create'
    ]);
    $router->post('icommercecheckmos', [
        'as' => 'admin.icommercecheckmo.icommercecheckmo.store',
        'uses' => 'IcommerceCheckmoController@store',
        'middleware' => 'can:icommercecheckmo.icommercecheckmos.create'
    ]);
    $router->get('icommercecheckmos/{icommercecheckmo}/edit', [
        'as' => 'admin.icommercecheckmo.icommercecheckmo.edit',
        'uses' => 'IcommerceCheckmoController@edit',
        'middleware' => 'can:icommercecheckmo.icommercecheckmos.edit'
    ]);
    $router->put('icommercecheckmos/{id}', [
        'as' => 'admin.icommercecheckmo.icommercecheckmo.update',
        'uses' => 'IcommerceCheckmoController@update',
        'middleware' => 'can:icommercecheckmo.icommercecheckmos.edit'
    ]);
    $router->delete('icommercecheckmos/{icommercecheckmo}', [
        'as' => 'admin.icommercecheckmo.icommercecheckmo.destroy',
        'uses' => 'IcommerceCheckmoController@destroy',
        'middleware' => 'can:icommercecheckmo.icommercecheckmos.destroy'
    ]);
// append

});
