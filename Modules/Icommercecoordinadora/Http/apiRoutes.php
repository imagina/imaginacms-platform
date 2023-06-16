<?php

use Illuminate\Routing\Router;

Route::prefix('icommercecoordinadora/v1')->group(function (Router $router) {
    $router->get('/', [
        'as' => 'icommercecoordinadora.api.coordinadora.init',
        'uses' => 'IcommerceCoordinadoraApiController@init',
    ]);

    $router->get('/getCities', [
        'as' => 'icommercecoordinadora.api.coordinadora.getcities',
        'uses' => 'IcommerceCoordinadoraApiController@getCities',
    ]);
});
