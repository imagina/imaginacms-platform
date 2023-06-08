<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'icommercexpay'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'icommercexpay.api.xpay.init',
        'uses' => 'IcommerceXpayApiController@init',
    ]);

    $router->post('/get-token-login', [
        'as' => 'icommercexpay.api.xpay.gettokenlogin',
        'uses' => 'IcommerceXpayApiController@getTokenLogin',
    ]);

    $router->get('/get-currencies', [
        'as' => 'icommercexpay.api.xpay.getCurrencies',
        'uses' => 'IcommerceXpayApiController@getCurrencies',
    ]);

    $router->post('/create-payment', [
        'as' => 'icommercexpay.api.xpay.createPayment',
        'uses' => 'IcommerceXpayApiController@createPayment',
    ]);

    $router->post('/response', [
        'as' => 'icommercexpay.api.xpay.response',
        'uses' => 'IcommerceXpayApiController@response',
    ]);

});