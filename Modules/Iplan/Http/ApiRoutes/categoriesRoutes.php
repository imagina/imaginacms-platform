<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => 'categories'], function (Router $router) {


  $router->post('/', [
    'as' => 'api.iplan.categories.create',
    'uses' => 'CategoryController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => 'api.iplan.categories.index',
    'uses' => 'CategoryController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => 'api.iplan.categories.update',
    'uses' => 'CategoryController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.iplan.categories.delete',
    'uses' => 'CategoryController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.iplan.categories.show',
    'uses' => 'CategoryController@show',
  ]);

});
