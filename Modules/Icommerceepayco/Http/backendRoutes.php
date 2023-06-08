<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/icommerceepayco'], function (Router $router) {
    $router->bind('icommerceepayco', function ($id) {
        return app('Modules\Icommerceepayco\Repositories\IcommerceEpaycoRepository')->find($id);
    });
    $router->get('icommerceepaycos', [
        'as' => 'admin.icommerceepayco.icommerceepayco.index',
        'uses' => 'IcommerceEpaycoController@index',
        'middleware' => 'can:icommerceepayco.icommerceepaycos.index'
    ]);
    $router->get('icommerceepaycos/create', [
        'as' => 'admin.icommerceepayco.icommerceepayco.create',
        'uses' => 'IcommerceEpaycoController@create',
        'middleware' => 'can:icommerceepayco.icommerceepaycos.create'
    ]);
    $router->post('icommerceepaycos', [
        'as' => 'admin.icommerceepayco.icommerceepayco.store',
        'uses' => 'IcommerceEpaycoController@store',
        'middleware' => 'can:icommerceepayco.icommerceepaycos.create'
    ]);
    $router->get('icommerceepaycos/{icommerceepayco}/edit', [
        'as' => 'admin.icommerceepayco.icommerceepayco.edit',
        'uses' => 'IcommerceEpaycoController@edit',
        'middleware' => 'can:icommerceepayco.icommerceepaycos.edit'
    ]);
    $router->put('icommerceepaycos/{id}', [
        'as' => 'admin.icommerceepayco.icommerceepayco.update',
        'uses' => 'IcommerceEpaycoController@update',
        'middleware' => 'can:icommerceepayco.icommerceepaycos.edit'
    ]);
    $router->delete('icommerceepaycos/{icommerceepayco}', [
        'as' => 'admin.icommerceepayco.icommerceepayco.destroy',
        'uses' => 'IcommerceEpaycoController@destroy',
        'middleware' => 'can:icommerceepayco.icommerceepaycos.destroy'
    ]);
// append

});
