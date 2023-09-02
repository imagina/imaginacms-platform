<?php

use Illuminate\Routing\Router;

Route::prefix('/qreable/v1')->group(function (Router $router) {
    $router->get('/qr/{criteria}', [
        'as' => 'api.qreable.show',
        'uses' => 'QrApiController@show',
    ]);
});
