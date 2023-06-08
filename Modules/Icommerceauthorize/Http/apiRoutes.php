<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'icommerceauthorize/v1'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'icommerceauthorize.api.authorize.init',
        'uses' => 'IcommerceAuthorizeApiController@init',
    ]);

    $router->get('/response', [
        'as' => 'icommerceauthorize.api.authorize.response',
        'uses' => 'IcommerceAuthorizeApiController@response',
    ]);

   

});