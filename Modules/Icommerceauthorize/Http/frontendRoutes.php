<?php

use Illuminate\Routing\Router;

Route::prefix('icommerceauthorize')->group(function (Router $router) {
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();

    $router->get('/{eUrl}', [
        'as' => 'icommerceauthorize',
        'uses' => 'PublicController@index',
    ]);

    $router->get('/pay/{orderId}/{transactionId}/{oval}/{odes}', [
        'as' => 'icommerceauthorize.payment',
        'uses' => 'PublicController@payment',
    ]);
});
