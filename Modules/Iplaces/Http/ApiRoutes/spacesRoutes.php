<?php
use Illuminate\Routing\Router;
$router->group(['prefix' => 'spaces'], function (Router $router) {
  
  
  $router->post('/', [
    'as' => 'api.iplaces.spaces.create',
    'uses' => 'SpaceController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => 'api.iplaces.spaces.index',
    'uses' => 'SpaceController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => 'api.iplaces.spaces.update',
    'uses' => 'SpaceController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.iplaces.spaces.delete',
    'uses' => 'SpaceController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.iplaces.spaces.show',
    'uses' => 'SpaceController@show',
  ]);
  

});