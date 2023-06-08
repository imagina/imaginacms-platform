<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'icommercecoordinadora/v1'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'icommercecoordinadora.api.coordinadora.init',
        'uses' => 'IcommerceCoordinadoraApiController@init',
    ]);

    $router->get('/getCities', [
        'as' => 'icommercecoordinadora.api.coordinadora.getcities',
        'uses' => 'IcommerceCoordinadoraApiController@getCities',
    ]);

   

});