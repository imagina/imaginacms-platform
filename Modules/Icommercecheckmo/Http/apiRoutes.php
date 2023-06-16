<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'icommercecheckmo'], function (Router $router) {
    $router->get('/', [
        'as' => 'icommercecheckmo.api.checkmo.init',
        'uses' => 'IcommerceCheckmoApiController@init',
    ]);

    $router->get('/response', [
        'as' => 'icommercecheckmo.api.checkmo.response',
        'uses' => 'IcommerceCheckmoApiController@response',
    ]);
});
