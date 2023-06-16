<?php

use Illuminate\Routing\Router;

Route::prefix('icommercepaymentez')->group(function (Router $router) {
    $router->get('/{eUrl}', [
        'as' => 'icommercepaymentez',
        'uses' => 'PublicController@index',
    ]);

    $router->get('/confirmation/{orderId}', [
        'as' => 'icommercepaymentez.confirmation',
        'uses' => 'PublicController@confirmation',
    ]);
});
