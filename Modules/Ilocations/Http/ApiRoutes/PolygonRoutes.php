<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/polygons'], function (Router $router) {

  //Route create
  $router->post('/', [
    'as' => 'api.ilocations.polygons.create',
    'uses' => 'PolygonApiController@create',
    'middleware' => ['auth:api']
  ]);

  //Route index
  $router->get('/', [
    'as' => 'api.ilocations.polygons.index',
    'uses' => 'PolygonApiController@index',
  ]);

  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.ilocations.polygons.show',
    'uses' => 'PolygonApiController@show',
  ]);

  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.ilocations.polygons.update',
    'uses' => 'PolygonApiController@update',
    'middleware' => ['auth:api']
  ]);

  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.ilocations.polygons.delete',
    'uses' => 'PolygonApiController@delete',
    'middleware' => ['auth:api']
  ]);

});
