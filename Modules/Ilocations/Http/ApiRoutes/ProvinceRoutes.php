<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/provinces'], function (Router $router) {

  //Route create
  $router->post('/', [
    'as' => 'api.ilocations.provinces.create',
    'uses' => 'ProvinceApiController@create',
    'middleware' => ['auth:api']
  ]);

  //Route index
  $router->get('/', [
    'as' => 'api.ilocations.provinces.index',
    'uses' => 'ProvinceApiController@index',
  ]);

  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.ilocations.provinces.show',
    'uses' => 'ProvinceApiController@show',
  ]);

  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.ilocations.provinces.update',
    'uses' => 'ProvinceApiController@update',
    'middleware' => ['auth:api']
  ]);

  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.ilocations.provinces.delete',
    'uses' => 'ProvinceApiController@delete',
    'middleware' => ['auth:api']
  ]);

});
