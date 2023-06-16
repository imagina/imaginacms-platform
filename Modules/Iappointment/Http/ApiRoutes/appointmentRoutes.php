<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => '/appointments'], function (Router $router) {
    $router->post('/', [
        'as' => 'api.iappointment.appointments.create',
        'uses' => 'AppointmentApiController@create',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/', [
        'as' => 'api.iappointment.appointments.index',
        'uses' => 'AppointmentApiController@index',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.iappointment.appointments.show',
        'uses' => 'AppointmentApiController@show',
        'middleware' => ['auth:api'],
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.iappointment.appointments.update',
        'uses' => 'AppointmentApiController@update',
        'middleware' => ['auth:api'],
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.iappointment.appointments.delete',
        'uses' => 'AppointmentApiController@delete',
        'middleware' => ['auth:api'],
    ]);
});
