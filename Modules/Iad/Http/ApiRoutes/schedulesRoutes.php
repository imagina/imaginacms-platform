<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'schedules'], function (Router $router) {
    $router->post('/', [
        'as' => 'api.iad.schedules.create',
        'uses' => 'ScheduleApiController@create',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/', [
        'as' => 'api.iad.schedules.index',
        'uses' => 'ScheduleApiController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.iad.schedules.update',
        'uses' => 'ScheduleApiController@update',
        'middleware' => ['auth:api'],
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.iad.schedules.delete',
        'uses' => 'ScheduleApiController@delete',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.iad.schedules.show',
        'uses' => 'ScheduleApiController@show',
    ]);
});
