<?php

use Illuminate\Routing\Router;

Route::prefix('/appointment-statuses')->group(function (Router $router) {
    $router->post('/', [
        'as' => 'api.iappointment.appointmentStatuses.create',
        'uses' => 'AppointmentStatusApiController@create',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/', [
        'as' => 'api.iappointment.appointmentStatuses.index',
        'uses' => 'AppointmentStatusApiController@index',
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.iappointment.appointmentStatuses.show',
        'uses' => 'AppointmentStatusApiController@show',
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.iappointment.appointmentStatuses.update',
        'uses' => 'AppointmentStatusApiController@update',
        'middleware' => ['auth:api'],
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.iappointment.appointmentStatuses.delete',
        'uses' => 'AppointmentStatusApiController@delete',
        'middleware' => ['auth:api'],
    ]);
});
