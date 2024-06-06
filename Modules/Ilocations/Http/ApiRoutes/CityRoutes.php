<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/cities'], function (Router $router) {

  //Route create
  $router->post('/', [
    'as' => 'api.ilocations.cities.create',
    'uses' => 'CityApiController@create',
    'middleware' => ['auth:api']
  ]);

  //Route index
  $router->get('/', [
    'as' => 'api.ilocations.cities.index',
    'uses' => 'CityApiController@index',
  ]);

  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.ilocations.cities.show',
    'uses' => 'CityApiController@show',
  ]);

  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.ilocations.cities.update',
    'uses' => 'CityApiController@update',
    'middleware' => ['auth:api']
  ]);

  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.ilocations.cities.delete',
    'uses' => 'CityApiController@delete',
    'middleware' => ['auth:api']
  ]);

});
