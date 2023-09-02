<?php

use Illuminate\Routing\Router;

Route::prefix('icommercepaymentez/v1')->group(function (Router $router) {
    $router->get('/', [
        'as' => 'icommercepaymentez.api.paymentez.init',
        'uses' => 'IcommercePaymentezApiController@init',
    ]);

    $router->post('/response', [
        'as' => 'icommercepaymentez.api.paymentez.response',
        'uses' => 'IcommercePaymentezApiController@response',
    ]);
});
