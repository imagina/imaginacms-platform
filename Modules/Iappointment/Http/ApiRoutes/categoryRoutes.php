<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => '/categories'], function (Router $router) {

    $router->post('/', [
        'as' => 'api.iappointment.categories.create',
        'uses' => 'CategoryApiController@create',
        'middleware' => ['auth:api']
    ]);
    $router->get('/', [
        'as' => 'api.iappointment.categories.index',
        'uses' => 'CategoryApiController@index',
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.iappointment.categories.show',
        'uses' => 'CategoryApiController@show',
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.iappointment.categories.update',
        'uses' => 'CategoryApiController@update',
        'middleware' => ['auth:api']
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.iappointment.categories.delete',
        'uses' => 'CategoryApiController@delete',
        'middleware' => ['auth:api']
    ]);

});
