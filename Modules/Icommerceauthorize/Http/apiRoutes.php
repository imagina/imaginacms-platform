<?php

use Illuminate\Routing\Router;

Route::prefix('icommerceauthorize/v1')->group(function (Router $router) {
    $router->get('/', [
        'as' => 'icommerceauthorize.api.authorize.init',
        'uses' => 'IcommerceAuthorizeApiController@init',
    ]);

    $router->get('/response', [
        'as' => 'icommerceauthorize.api.authorize.response',
        'uses' => 'IcommerceAuthorizeApiController@response',
    ]);
});
