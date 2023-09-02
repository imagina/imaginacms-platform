<?php

use Illuminate\Routing\Router;

Route::prefix('icommercepayu')->group(function (Router $router) {
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();

    $router->get('/back', [
        'as' => 'icommercepayu.back',
        'uses' => 'PublicController@back',
    ]);

    $router->get('/{eUrl}', [
        'as' => 'icommercepayu',
        'uses' => 'PublicController@index',
    ]);
});
