<?php

use Illuminate\Routing\Router;

Route::prefix('icommercepaypal')->group(function (Router $router) {
    $router->get('/', [
        'as' => 'icommercepaypal.api.paypal.init',
        'uses' => 'IcommercePaypalApiController@init',
    ]);
});
