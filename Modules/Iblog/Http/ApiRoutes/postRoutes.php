<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'posts'], function (Router $router) {
  //Route create
  $router->post('/', [
    'as' => 'api.iblog.post.create',
    'uses' => 'PostApiController@create',
    'middleware' => ['auth:api']
  ]);
  
  //Route index
  $router->get('/', [
    'as' => 'api.iblog.post.get.items.by',
    'uses' => 'PostApiController@index',
    //'middleware' => ['auth:api']
  ]);
  
  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.iblog.post.get.item',
    'uses' => 'PostApiController@show',
    //'middleware' => ['auth:api']
  ]);
  
  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.iblog.post.update',
    'uses' => 'PostApiController@update',
    'middleware' => ['auth:api']
  ]);
  
  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.iblog.post.delete',
    'uses' => 'PostApiController@delete',
    'middleware' => ['auth:api']
  ]);
  
});
