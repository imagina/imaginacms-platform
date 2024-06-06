<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/geozones'], function (Router $router) {

  //Route create
  $router->post('/', [
    'as' => 'api.ilocations.geozones.create',
    'uses' => 'GeozoneApiController@create',
    'middleware' => ['auth:api']
  ]);

  //Route index
  $router->get('/', [
    'as' => 'api.ilocations.geozones.index',
    'uses' => 'GeozoneApiController@index',
  ]);

  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.ilocations.geozones.show',
    'uses' => 'GeozoneApiController@show',
  ]);

  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.ilocations.geozones.update',
    'uses' => 'GeozoneApiController@update',
    'middleware' => ['auth:api']
  ]);

  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.ilocations.geozones.delete',
    'uses' => 'GeozoneApiController@delete',
    'middleware' => ['auth:api']
  ]);

});