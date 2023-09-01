<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => '/payment'], function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->get('/', [
        'as' => 'ipoint.api.payment.init',
        'uses' => 'PaymentApiController@init',
    ]);

    $router->post('/process-payment', [
        'as' => 'ipoint.api.payment.processPayment',
        'uses' => 'PaymentApiController@processPayment',
    ]);
});
