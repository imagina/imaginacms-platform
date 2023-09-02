<?php

use Illuminate\Routing\Router;

Route::prefix('icommercepayu')->group(function (Router $router) {
    $router->get('/', [
        'as' => 'icommercepayu.api.payu.init',
        'uses' => 'IcommercePayuApiController@init',
    ]);

    $router->get('/response', [
        'as' => 'icommercepayu.api.get.payu.response',
        'uses' => 'IcommercePayuApiController@response',
    ]);

    $router->post('/response', [
        'as' => 'icommercepayu.api.post.payu.response',
        'uses' => 'IcommercePayuApiController@response',
    ]);
});
