<?php

use Illuminate\Routing\Router;

Route::prefix('/configs')->group(function (Router $router) {
    $router->get('/', [
        'uses' => 'ConfigsApiController@index',
    ]);
    $router->get('/modules-info', [
        'uses' => 'ConfigsApiController@modulesInfo',
    ]);
});
