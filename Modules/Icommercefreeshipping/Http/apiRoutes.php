<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'icommercefreeshipping'], function (Router $router) {
    $router->get('/', [
        'as' => 'icommercefreeshipping.api.freeshipping.init',
        'uses' => 'IcommerceFreeshippingApiController@init',
    ]);
});
