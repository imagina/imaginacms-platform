<?php

use Illuminate\Routing\Router;

Route::prefix('icommerceopenpay/v1')->group(function (Router $router) {
    $router->get('/', [
        'as' => 'icommerceopenpay.api.openpay.init',
        'uses' => 'IcommerceOpenpayApiController@init',
    ]);

    $router->post('/processPayment', [
        'as' => 'icommerceopenpay.api.openpay.processPayment',
        'uses' => 'IcommerceOpenpayApiController@processPayment',
    ]);

    $router->post('/processPaymentPse', [
        'as' => 'icommerceopenpay.api.openpay.processPaymentPse',
        'uses' => 'IcommerceOpenpayApiController@processPaymentPse',
    ]);

    $router->post('/confirmation', [
        'as' => 'icommerceopenpay.api.openpay.confirmation',
        'uses' => 'IcommerceOpenpayApiController@confirmation',
    ]);
});
