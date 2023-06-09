<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'categories'], function (Router $router) {
    //Route create
    $router->post('/', [
        'as' => 'api.idocs.category.create',
        'uses' => 'CategoryApiController@create',
        'middleware' => ['auth:api'],
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.idocs.category.get.items.by',
        'uses' => 'CategoryApiController@index',
        'middleware' => ['auth:api'],
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.idocs.category.get.item',
        'uses' => 'CategoryApiController@show',
        'middleware' => ['auth:api'],
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.idocs.category.update',
        'uses' => 'CategoryApiController@update',
        'middleware' => ['auth:api'],
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.idocs.category.delete',
        'uses' => 'CategoryApiController@delete',
        'middleware' => ['auth:api'],
    ]);
});
