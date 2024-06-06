<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/neighborhoods'], function (Router $router) {

  //Route create
  $router->post('/', [
    'as' => 'api.ilocations.neighborhoods.create',
    'uses' => 'NeighborhoodApiController@create',
    'middleware' => ['auth:api']
  ]);

  //Route index
  $router->get('/', [
    'as' => 'api.ilocations.neighborhoods.index',
    'uses' => 'NeighborhoodApiController@index',
  ]);

  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.ilocations.neighborhoods.show',
    'uses' => 'NeighborhoodApiController@show',
  ]);

  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.ilocations.neighborhoods.update',
    'uses' => 'NeighborhoodApiController@update',
    'middleware' => ['auth:api']
  ]);

  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.ilocations.neighborhoods.delete',
    'uses' => 'NeighborhoodApiController@delete',
    'middleware' => ['auth:api']
  ]);

});
