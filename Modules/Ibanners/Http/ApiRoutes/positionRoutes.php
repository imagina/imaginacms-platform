<?php

use Illuminate\Routing\Router;

Route::prefix('/positions')->group(function (Router $router) {
    $router->post('/', [
        'as' => 'api.ibanners.positions.create',
        'uses' => 'PositionApiController@create',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/', [
        'as' => 'api.ibanners.positions.index',
        'uses' => 'PositionApiController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.ibanners.positions.update',
        'uses' => 'PositionApiController@update',
        'middleware' => ['auth:api'],
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.ibanners.positions.delete',
        'uses' => 'PositionApiController@delete',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.ibanners.positions.show',
        'uses' => 'PositionApiController@show',
    ]);

    $router->post('/order-banners', [
        'as' => 'api.ibanners.positions.banner.update',
        'uses' => 'BannerController@update',
        'middleware' => ['auth:api'],
    ]);
});
