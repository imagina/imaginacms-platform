<?php

use Illuminate\Routing\Router;

Route::prefix('/banners')->group(function (Router $router) {
    $router->post('/', [
        'as' => 'api.ibanners.banners.create',
        'uses' => 'BannerApiController@create',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/', [
        'as' => 'api.ibanners.banners.index',
        'uses' => 'BannerApiController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.ibanners.banners.update',
        'uses' => 'BannerApiController@update',
        'middleware' => ['auth:api'],
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.ibanners.banners.delete',
        'uses' => 'BannerApiController@delete',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.ibanners.banners.show',
        'uses' => 'BannerApiController@show',
    ]);
});
