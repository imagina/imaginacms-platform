<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'icommercebraintree'], function (Router $router) {
    $router->get('/{eUrl}', [
        'as' => 'icommercebraintree',
        'uses' => 'PublicController@index',
    ]);

    $router->post('/processPayment/{eUrl}', [
        'as' => 'icommercebraintree.processPayment',
        'uses' => 'PublicController@processPayment',
    ]);
});
