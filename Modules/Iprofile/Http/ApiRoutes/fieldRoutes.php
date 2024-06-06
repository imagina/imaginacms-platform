<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/fields','middleware' => ['auth:api']], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.iprofile.fields.create',
    'uses' => 'FieldApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.iprofile.fields.index',
    'uses' => 'FieldApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.iprofile.fields.update',
    'uses' => 'FieldApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.iprofile.fields.delete',
    'uses' => 'FieldApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.iprofile.fields.show',
    'uses' => 'FieldApiController@show',
  ]);
  
});