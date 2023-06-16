<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('/requests')->group(function (Router $router) {
    //Route create
    $router->post('/', [
        'as' => 'ichecking.requests.create',
        'uses' => 'RequestApiController@create',
        'middleware' => ['auth:api'],
    ]);

    //Route index
    $router->get('/', [
        'as' => 'ichecking.requests.get.items.by',
        'uses' => 'RequestApiController@index',
        'middleware' => ['auth:api'],
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'ichecking.requests.get.item',
        'uses' => 'RequestApiController@show',
        'middleware' => ['auth:api'],
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'ichecking.requests.update',
        'uses' => 'RequestApiController@update',
        'middleware' => ['auth:api'],
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'ichecking.requests.delete',
        'uses' => 'RequestApiController@delete',
        'middleware' => ['auth:api'],
    ]);
});
