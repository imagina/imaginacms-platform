<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => 'places'], function (Router $router) {
  
  
  $router->post('/', [
    'as' => 'api.iplaces.places.create',
    'uses' => 'PlaceController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => 'api.iplaces.places.index',
    'uses' => 'PlaceController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => 'api.iplaces.places.update',
    'uses' => 'PlaceController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.iplaces.places.delete',
    'uses' => 'PlaceController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.iplaces.places.show',
    'uses' => 'PlaceController@show',
  ]);
  
});