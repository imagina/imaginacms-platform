<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/jobs'], function (Router $router) {
  //Route create
  $router->post('/', [
    'as' => 'ichecking.jobs.create',
    'uses' => 'JobApiController@create',
    'middleware' => ['auth:api']
  ]);
  
  //Route index
  $router->get('/', [
    'as' => 'ichecking.jobs.get.items.by',
    'uses' => 'JobApiController@index',
    'middleware' => ['auth:api']
  ]);
  
  //Route show
  $router->get('/{criteria}', [
    'as' => 'ichecking.jobs.get.item',
    'uses' => 'JobApiController@show',
    'middleware' => ['auth:api']
  ]);
  
  //Route update
  $router->put('/{criteria}', [
    'as' => 'ichecking.jobs.update',
    'uses' => 'JobApiController@update',
    'middleware' => ['auth:api']
  ]);
  
  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'ichecking.jobs.delete',
    'uses' => 'JobApiController@delete',
    'middleware' => ['auth:api']
  ]);
});