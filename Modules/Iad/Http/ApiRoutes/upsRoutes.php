<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'ups'], function (Router $router) {
    $router->post('/', [
        'as' => 'api.iad.ups.create',
        'uses' => 'UpApiController@create',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/', [
        'as' => 'api.iad.ups.index',
        'uses' => 'UpApiController@index',
    ]);
    $router->get('/status', [
        'as' => 'api.iad.ups.status.index',
        'uses' => 'UpApiController@indexStatus',
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.iad.ups.show',
        'uses' => 'UpApiController@show',
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.iad.ups.update',
        'uses' => 'UpApiController@update',
        'middleware' => ['auth:api'],
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.iad.ups.delete',
        'uses' => 'UpApiController@delete',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.iad.ups.show',
        'uses' => 'UpApiController@show',
    ]);
});
