<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/categories'], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.ievent.categories.create',
    'uses' => 'CategoryApiController@create',
    'middleware' => ['auth:api','auth-can:ievent.categories.create']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.ievent.categories.index',
    'uses' => 'CategoryApiController@index',
    //'middleware' => 'auth-can:ievent.categories.index'
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.ievent.categories.update',
    'uses' => 'CategoryApiController@update',
    'middleware' => ['auth:api','auth-can:ievent.categories.edit']
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.ievent.categories.delete',
    'uses' => 'CategoryApiController@delete',
    'middleware' => ['auth:api','auth-can:ievent.categories.destroy']
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.ievent.categories.show',
    'uses' => 'CategoryApiController@show',
    //'middleware' => 'auth-can:ievent.categories.show'
  ]);
  
});