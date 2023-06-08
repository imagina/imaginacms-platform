<?php
use Illuminate\Routing\Router;
$router->group(['prefix' => 'categories'], function (Router $router) {
  
  
  $router->post('/', [
    'as' => 'api.iplaces.categories.create',
    'uses' => 'CategoryController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => 'api.iplaces.categories.index',
    'uses' => 'CategoryController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => 'api.iplaces.categories.update',
    'uses' => 'CategoryController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.iplaces.categories.delete',
    'uses' => 'CategoryController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.iplaces.categories.show',
    'uses' => 'CategoryController@show',
  ]);

});