<?php

use Illuminate\Routing\Router;

Route::prefix('/templates')->group(function (Router $router) {
    //Route create
    $router->post('/', [
        'as' => 'api.template.create',
        'uses' => 'TemplateApiController@create',
        'middleware' => ['auth:api'],
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.template.get.items.by',
        'uses' => 'TemplateApiController@index',
        'middleware' => ['auth:api'],
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.template.get.item',
        'uses' => 'TemplateApiController@show',
        'middleware' => ['auth:api'],
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.template.update',
        'uses' => 'TemplateApiController@update',
        'middleware' => ['auth:api'],
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.template.delete',
        'uses' => 'TemplateApiController@delete',
        'middleware' => ['auth:api'],
    ]);
});
