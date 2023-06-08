<?php
use Illuminate\Routing\Router;
$router->group(['prefix' => 'services'], function (Router $router) {
  
  
  $router->post('/', [
    'as' => 'api.iplaces.services.create',
    'uses' => 'ServiceController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => 'api.iplaces.services.index',
    'uses' => 'ServiceController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => 'api.iplaces.services.update',
    'uses' => 'ServiceController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.iplaces.services.delete',
    'uses' => 'ServiceController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.iplaces.services.show',
    'uses' => 'ServiceController@show',
  ]);
  
  
  
});