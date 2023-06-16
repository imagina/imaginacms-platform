<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'fields'], function (Router $router) {
    $router->post('/', [
        'as' => 'api.iad.fields.create',
        'uses' => 'FieldApiController@create',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/', [
        'as' => 'api.iad.fields.index',
        'uses' => 'FieldApiController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.iad.fields.update',
        'uses' => 'FieldApiController@update',
        'middleware' => ['auth:api'],
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.iad.fields.delete',
        'uses' => 'FieldApiController@delete',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.iad.fields.show',
        'uses' => 'FieldApiController@show',
    ]);
});
