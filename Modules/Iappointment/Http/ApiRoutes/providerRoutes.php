<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/providers'], function (Router $router) {
    $router->post('/', [
        'as' => 'api.iappointment.providers.create',
        'uses' => 'ProviderApiController@create',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/', [
        'as' => 'api.iappointment.providers.index',
        'uses' => 'ProviderApiController@index',
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.iappointment.providers.show',
        'uses' => 'ProviderApiController@show',
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.iappointment.providers.update',
        'uses' => 'ProviderApiController@update',
        'middleware' => ['auth:api'],
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.iappointment.providers.delete',
        'uses' => 'ProviderApiController@delete',
        'middleware' => ['auth:api'],
    ]);
});
