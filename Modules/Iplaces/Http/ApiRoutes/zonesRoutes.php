<?php
use Illuminate\Routing\Router;
$router->group(['prefix' => 'zones'], function (Router $router) {
  
  
  $router->post('/', [
    'as' => 'api.iplaces.zones.create',
    'uses' => 'ZoneController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => 'api.iplaces.zones.index',
    'uses' => 'ZoneController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => 'api.iplaces.zones.update',
    'uses' => 'ZoneController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.iplaces.zones.delete',
    'uses' => 'ZoneController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.iplaces.zones.show',
    'uses' => 'ZoneController@show',
  ]);
  
  
});