<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'icommercecredibanco'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'icommercecredibanco.api.credibanco.init',
        'uses' => 'IcommerceCredibancoApiController@init',
    ]);

    $router->get('/getUpdateOrder', [
        'as' => 'icommercecredibanco.api.credibanco.getUpdateOrder',
        'uses' => 'IcommerceCredibancoApiController@getUpdateOrder',
    ]);

   

});