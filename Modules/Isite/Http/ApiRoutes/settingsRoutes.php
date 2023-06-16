<?php

use Illuminate\Routing\Router;

Route::prefix('/settings')->group(function (Router $router) {
    $router->post('/', [
        'uses' => 'SettingApiController@createOrUpdate',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/', [
        'uses' => 'SettingApiController@index',
        //'middleware' => ['auth:api']
    ]);
    $router->get('/{criteria}', [
        'uses' => 'SettingApiController@show',
    ]);
});
