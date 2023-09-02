<?php

use Illuminate\Routing\Router;

Route::prefix('icommercebraintree')->group(function (Router $router) {
    $router->get('/', [
        'as' => 'icommercebraintree.api.braintree.init',
        'uses' => 'IcommerceBraintreeApiController@init',
    ]);

    $router->get('/get-client-token', [
        'as' => 'icommercebraintree.api.braintree.getClientToken',
        'uses' => 'IcommerceBraintreeApiController@getClientToken',
    ]);

    $router->post('/process-payment', [
        'as' => 'icommercebraintree.api.braintree.processPayment',
        'uses' => 'IcommerceBraintreeApiController@processPayment',
    ]);

    $router->get('/find-transaction/{id}', [
        'as' => 'icommercebraintree.api.braintree.findTransaction',
        'uses' => 'IcommerceBraintreeApiController@findTransaction',
    ]);
});
