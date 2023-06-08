<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/requestables'], function (Router $router) {
  $router->get('/', [
    'as' => 'requestables.index',
    'uses' => 'RequestableApiController@index',
    'middleware' => ['auth:api','auth-can:requestable.requestables.index']
  ]);
  
  $router->get('/config', [
    'as' => 'requestables.config',
    'uses' => 'RequestableApiController@config',
    'middleware' => ['auth:api','auth-can:requestable.requestables.manage']
  ]);
  
  $router->get('/{id}', [
    'as' => 'requestables.show',
    'uses' => 'RequestableApiController@show',
    'middleware' => ['auth:api','auth-can:requestable.requestables.index']
  ]);
  
  $router->put('/{id}', [
    'as' => 'requestables.update',
    'uses' => 'RequestableApiController@update',
    'middleware' => ['auth:api','auth-can:requestable.requestables.edit']
  ]);
  
  $router->post('/', [
    'as' => 'requestables.create',
    'uses' => 'RequestableApiController@create',
    'middleware' => ['auth:api','auth-can:requestable.requestables.create']
  ]);

  //Add comment to requestable
  $router->post('/{id}/comment', [
    'as' => 'requestables.comment',
    'uses' => 'RequestableApiController@addComment',
    'middleware' => ['auth:api','auth-can:requestable.requestables.edit']
  ]);
  
});