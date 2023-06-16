<?php

use Illuminate\Routing\Router;

Route::prefix('icommercewompi')->group(function (Router $router) {
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();

    $router->get('/{eUrl}', [
        'as' => 'icommercewompi',
        'uses' => 'PublicController@index',
    ]);

    $router->get('/payment/response/{orderId}', [
        'as' => 'icommercewompi.response',
        'uses' => 'PublicController@response',
    ]);
});
