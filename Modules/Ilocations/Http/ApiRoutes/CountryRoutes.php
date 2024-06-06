<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/countries'], function (Router $router) {

  //Route create
  $router->post('/', [
    'as' => 'api.ilocations.countries.create',
    'uses' => 'CountryApiController@create',
    'middleware' => ['auth:api']
  ]);

  //Route index
  $router->get('/', [
    'as' => 'api.ilocations.countries.index',
    'uses' => 'CountryApiController@index',
  ]);

  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.ilocations.countries.show',
    'uses' => 'CountryApiController@show',
  ]);

  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.ilocations.countries.update',
    'uses' => 'CountryApiController@update',
    'middleware' => ['auth:api']
  ]);

  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.ilocations.countries.delete',
    'uses' => 'CountryApiController@delete',
    'middleware' => ['auth:api']
  ]);

});
