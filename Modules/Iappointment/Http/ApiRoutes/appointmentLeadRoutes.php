<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/appointment-leads'], function (Router $router) {

    $router->post('/', [
        'as' => 'api.iappointment.appointmentLeads.create',
        'uses' => 'AppointmentLeadApiController@create',
        'middleware' => ['auth:api']
    ]);
    $router->get('/', [
        'as' => 'api.iappointment.appointmentLeads.index',
        'uses' => 'AppointmentLeadApiController@index',
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.iappointment.appointmentLeades.show',
        'uses' => 'AppointmentLeadApiController@show',
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.iappointment.appointmentLeads.update',
        'uses' => 'AppointmentLeadApiController@update',
        'middleware' => ['auth:api']
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.iappointment.appointmentLeads.delete',
        'uses' => 'AppointmentLeadApiController@delete',
        'middleware' => ['auth:api']
    ]);

});
