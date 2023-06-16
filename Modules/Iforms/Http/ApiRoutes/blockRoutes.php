<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'blocks'], function (Router $router) {
    //Route create
    $router->post('/', [
        'as' => 'api.iforms.blocks.create',
        'uses' => 'BlockApiController@create',
        'middleware' => ['auth:api'],
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.iforms.blocks.get.items.by',
        'uses' => 'BlockApiController@index',
        //'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.iforms.blocks.get.item',
        'uses' => 'BlockApiController@show',
        //'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.iforms.blocks.update',
        'uses' => 'BlockApiController@update',
        'middleware' => ['auth:api'],
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.iforms.blocks.delete',
        'uses' => 'BlockApiController@delete',
        //'middleware' => ['auth:api']
    ]);
});
