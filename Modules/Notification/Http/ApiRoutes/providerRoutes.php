<?php

use Illuminate\Routing\Router;

Route::prefix('/providers')->group(function (Router $router) {
    //Route create
    $router->post('/', [
        'as' => 'api.provider.create',
        'uses' => 'ProviderApiController@create',
        'middleware' => ['auth:api'],
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.provider.get.items.by',
        'uses' => 'ProviderApiController@index',
        'middleware' => ['auth:api'],
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.provider.get.item',
        'uses' => 'ProviderApiController@show',
        'middleware' => ['auth:api'],
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.provider.update',
        'uses' => 'ProviderApiController@update',
        'middleware' => ['auth:api'],
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.provider.delete',
        'uses' => 'ProviderApiController@delete',
        'middleware' => ['auth:api'],
    ]);
});
