<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('/icommercecoordinadora')->group(function (Router $router) {
    $router->bind('icommercecoordinadora', function ($id) {
        return app('Modules\Icommercecoordinadora\Repositories\IcommerceCoordinadoraRepository')->find($id);
    });
    $router->get('icommercecoordinadoras', [
        'as' => 'admin.icommercecoordinadora.icommercecoordinadora.index',
        'uses' => 'IcommerceCoordinadoraController@index',
        'middleware' => 'can:icommercecoordinadora.icommercecoordinadoras.index',
    ]);
    $router->get('icommercecoordinadoras/create', [
        'as' => 'admin.icommercecoordinadora.icommercecoordinadora.create',
        'uses' => 'IcommerceCoordinadoraController@create',
        'middleware' => 'can:icommercecoordinadora.icommercecoordinadoras.create',
    ]);
    $router->post('icommercecoordinadoras', [
        'as' => 'admin.icommercecoordinadora.icommercecoordinadora.store',
        'uses' => 'IcommerceCoordinadoraController@store',
        'middleware' => 'can:icommercecoordinadora.icommercecoordinadoras.create',
    ]);
    $router->get('icommercecoordinadoras/{icommercecoordinadora}/edit', [
        'as' => 'admin.icommercecoordinadora.icommercecoordinadora.edit',
        'uses' => 'IcommerceCoordinadoraController@edit',
        'middleware' => 'can:icommercecoordinadora.icommercecoordinadoras.edit',
    ]);
    $router->put('icommercecoordinadoras/{icommercecoordinadora}', [
        'as' => 'admin.icommercecoordinadora.icommercecoordinadora.update',
        'uses' => 'IcommerceCoordinadoraController@update',
        'middleware' => 'can:icommercecoordinadora.icommercecoordinadoras.edit',
    ]);
    $router->delete('icommercecoordinadoras/{icommercecoordinadora}', [
        'as' => 'admin.icommercecoordinadora.icommercecoordinadora.destroy',
        'uses' => 'IcommerceCoordinadoraController@destroy',
        'middleware' => 'can:icommercecoordinadora.icommercecoordinadoras.destroy',
    ]);
    // append
});
