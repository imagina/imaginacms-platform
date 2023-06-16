<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'icommercepaypal'], function (Router $router) {
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();

    $router->get('/payment/response/{orderId}/{transactionId}', [
        'as' => 'icommercepaypal.response',
        'uses' => 'PublicController@response',
    ]);
});
