<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/events','middleware' => ['auth:api']], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

  $router->post('/', [
    'as' => $locale . 'api.ievent.events.create',
    'uses' => 'EventApiController@create',
    'middleware' => 'auth-can:ievent.events.create'
  ]);
  $router->get('/', [
    'as' => $locale . 'api.ievent.events.index',
    'uses' => 'EventApiController@index',
    'middleware' => 'auth-can:ievent.events.index'
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.ievent.events.update',
    'uses' => 'EventApiController@update',
    'middleware' => 'auth-can:ievent.events.edit'
  ]);
  /*
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.ievent.events.delete',
    'uses' => 'EventApiController@delete',
    'middleware' => 'auth-can:ievent.events.destroy'
  ]);*/

  $router->get('/{criteria}', [
    'as' => $locale . 'api.ievent.events.show',
    'uses' => 'EventApiController@show',
    'middleware' => 'auth-can:ievent.events.show'
  ]);

});

$router->group(['prefix' => '/events-public'], function (Router $router) {
  $router->get('/{criteria}', [
    'as' => 'api.ievent.events.show.public',
    'uses' => 'EventApiController@showPublic'
  ]);
});
