<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/localities'], function (Router $router) {
    //Route create
    $router->post('/', [
        'as' => 'api.ilocations.localities.create',
        'uses' => 'LocalityApiController@create',
        'middleware' => ['auth:api'],
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.ilocations.localities.index',
        'uses' => 'LocalityApiController@index',
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.ilocations.localities.show',
        'uses' => 'LocalityApiController@show',
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.ilocations.localities.update',
        'uses' => 'LocalityApiController@update',
        'middleware' => ['auth:api'],
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.ilocations.localities.delete',
        'uses' => 'LocalityApiController@delete',
        'middleware' => ['auth:api'],
    ]);
});
