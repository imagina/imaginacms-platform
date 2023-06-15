<?php

use Illuminate\Routing\Router;
/** @var Router $router */

Route::group(['prefix' =>'/icommercepaypal'], function (Router $router) {
    $router->bind('icommercepaypal', function ($id) {
        return app('Modules\Icommercepaypal\Repositories\IcommercePaypalRepository')->find($id);
    });
    $router->get('icommercepaypals', [
        'as' => 'admin.icommercepaypal.icommercepaypal.index',
        'uses' => 'IcommercePaypalController@index',
        'middleware' => 'can:icommercepaypal.icommercepaypals.index'
    ]);
    $router->get('icommercepaypals/create', [
        'as' => 'admin.icommercepaypal.icommercepaypal.create',
        'uses' => 'IcommercePaypalController@create',
        'middleware' => 'can:icommercepaypal.icommercepaypals.create'
    ]);
    $router->post('icommercepaypals', [
        'as' => 'admin.icommercepaypal.icommercepaypal.store',
        'uses' => 'IcommercePaypalController@store',
        'middleware' => 'can:icommercepaypal.icommercepaypals.create'
    ]);
    $router->get('icommercepaypals/{icommercepaypal}/edit', [
        'as' => 'admin.icommercepaypal.icommercepaypal.edit',
        'uses' => 'IcommercePaypalController@edit',
        'middleware' => 'can:icommercepaypal.icommercepaypals.edit'
    ]);
    $router->put('icommercepaypals/{id}', [
        'as' => 'admin.icommercepaypal.icommercepaypal.update',
        'uses' => 'IcommercePaypalController@update',
        'middleware' => 'can:icommercepaypal.icommercepaypals.edit'
    ]);
    $router->delete('icommercepaypals/{icommercepaypal}', [
        'as' => 'admin.icommercepaypal.icommercepaypal.destroy',
        'uses' => 'IcommercePaypalController@destroy',
        'middleware' => 'can:icommercepaypal.icommercepaypals.destroy'
    ]);
// append

});
