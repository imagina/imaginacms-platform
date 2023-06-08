<?php
use Illuminate\Routing\Router;
$router->group(['prefix' => 'schedules'], function (Router $router) {
  
  
  $router->post('/', [
    'as' => 'api.iplaces.schedules.create',
    'uses' => 'ScheduleController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => 'api.iplaces.schedules.index',
    'uses' => 'ScheduleController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => 'api.iplaces.schedules.update',
    'uses' => 'ScheduleController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.iplaces.schedules.delete',
    'uses' => 'ScheduleController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.iplaces.schedules.show',
    'uses' => 'ScheduleController@show',
  ]);
  

});