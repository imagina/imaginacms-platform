<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => '/messages'], function (Router $router) {
    $router->post('/', [
        'as' => 'api.ichat.messages.create',
        'uses' => 'MessageApiController@create',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/', [
        'as' => 'api.ichat.messages.index',
        'uses' => 'MessageApiController@index',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.ichat.messages.show',
        'uses' => 'MessageApiController@show',
        'middleware' => ['auth:api'],
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.ichat.messages.update',
        'uses' => 'MessageApiController@update',
        'middleware' => ['auth:api'],
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.ichat.messages.delete',
        'uses' => 'MessageApiController@delete',
        'middleware' => ['auth:api'],
    ]);
});
