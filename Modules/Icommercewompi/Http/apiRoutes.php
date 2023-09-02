<?php

use Illuminate\Routing\Router;

Route::prefix('icommercewompi')->group(function (Router $router) {
    $router->get('/', [
        'as' => 'icommercewompi.api.wompi.init',
        'uses' => 'IcommerceWompiApiController@init',
    ]);

    $router->post('/confirmation', [
        'as' => 'icommercewompi.api.wompi.confirmation',
        'uses' => 'IcommerceWompiApiController@confirmation',
    ]);
});
