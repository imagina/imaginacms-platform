<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => '/qreable/v1'], function (Router $router) {
    $router->get('/qr/{criteria}', [
        'as' => 'api.qreable.show',
        'uses' => 'QrApiController@show',
    ]);
});
