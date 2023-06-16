<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'documents'], function (Router $router) {
    //Route create
    $router->post('/', [
        'as' => 'api.idocs.documents.create',
        'uses' => 'DocumentApiController@create',
        'middleware' => ['auth:api'],
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.idocs.documents.get.items.by',
        'uses' => 'DocumentApiController@index',
        'middleware' => ['auth:api'],
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.idocs.documents.get.item',
        'uses' => 'DocumentApiController@show',
        'middleware' => ['auth:api'],
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.idocs.documents.update',
        'uses' => 'DocumentApiController@update',
        'middleware' => ['auth:api'],
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.idocs.documents.delete',
        'uses' => 'DocumentApiController@delete',
        'middleware' => ['auth:api'],
    ]);
});
