<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'categories'], function (Router $router) {
  $router->post('/', [
    'as' => 'api.iad.categories.create',
    'uses' => 'CategoryApiController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => 'api.iad.categories.index',
    'uses' => 'CategoryApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => 'api.iad.categories.update',
    'uses' => 'CategoryApiController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.iad.categories.delete',
    'uses' => 'CategoryApiController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.iad.categories.show',
    'uses' => 'CategoryApiController@show',
  ]);
});
