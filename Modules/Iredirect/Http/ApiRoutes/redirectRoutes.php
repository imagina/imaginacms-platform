<?php

use Illuminate\Routing\Router;

Route::prefix('redirects')->group(function (Router $router) {
    //Route create
    $router->post('/', [
        'as' => 'api.iredirect.redirects.create',
        'uses' => 'RedirectApiController@create',
        'middleware' => ['auth:api'],
    ]);

    //Route index
    $router->get('/', [
        'as' => 'api.iredirect.redirects.get.items.by',
        'uses' => 'RedirectApiController@index',
        //'middleware' => ['auth:api']
    ]);

    //Route show
    $router->get('/{criteria}', [
        'as' => 'api.iredirect.redirects.get.item',
        'uses' => 'RedirectApiController@show',
        //'middleware' => ['auth:api']
    ]);

    //Route update
    $router->put('/{criteria}', [
        'as' => 'api.iredirect.redirects.update',
        'uses' => 'RedirectApiController@update',
        'middleware' => ['auth:api'],
    ]);

    //Route delete
    $router->delete('/{criteria}', [
        'as' => 'api.iredirect.redirects.delete',
        'uses' => 'RedirectApiController@delete',
        'middleware' => ['auth:api'],
    ]);
});
