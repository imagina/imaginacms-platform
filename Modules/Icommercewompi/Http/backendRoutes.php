<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('/icommercewompi')->group(function (Router $router) {
    $router->bind('icommercewompi', function ($id) {
        return app('Modules\Icommercewompi\Repositories\IcommerceWompiRepository')->find($id);
    });
    $router->get('icommercewompis', [
        'as' => 'admin.icommercewompi.icommercewompi.index',
        'uses' => 'IcommerceWompiController@index',
        'middleware' => 'can:icommercewompi.icommercewompis.index',
    ]);
    $router->get('icommercewompis/create', [
        'as' => 'admin.icommercewompi.icommercewompi.create',
        'uses' => 'IcommerceWompiController@create',
        'middleware' => 'can:icommercewompi.icommercewompis.create',
    ]);
    $router->post('icommercewompis', [
        'as' => 'admin.icommercewompi.icommercewompi.store',
        'uses' => 'IcommerceWompiController@store',
        'middleware' => 'can:icommercewompi.icommercewompis.create',
    ]);
    $router->get('icommercewompis/{icommercewompi}/edit', [
        'as' => 'admin.icommercewompi.icommercewompi.edit',
        'uses' => 'IcommerceWompiController@edit',
        'middleware' => 'can:icommercewompi.icommercewompis.edit',
    ]);
    $router->put('icommercewompis/{id}', [
        'as' => 'admin.icommercewompi.icommercewompi.update',
        'uses' => 'IcommerceWompiController@update',
        'middleware' => 'can:icommercewompi.icommercewompis.edit',
    ]);
    $router->delete('icommercewompis/{icommercewompi}', [
        'as' => 'admin.icommercewompi.icommercewompi.destroy',
        'uses' => 'IcommerceWompiController@destroy',
        'middleware' => 'can:icommercewompi.icommercewompis.destroy',
    ]);
    // append
});
