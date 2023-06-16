<?php

use Illuminate\Routing\Router;

Route::prefix('icommercefreeshipping')->group(function (Router $router) {
    $router->get('/', [
        'as' => 'icommercefreeshipping.api.freeshipping.init',
        'uses' => 'IcommerceFreeshippingApiController@init',
    ]);
});
