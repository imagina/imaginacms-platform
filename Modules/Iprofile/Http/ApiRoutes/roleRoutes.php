<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => '/roles'], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.iprofile.roles.create',
    'uses' => 'RoleApiController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => $locale . 'api.iprofile.roles.index',
    'uses' => 'RoleApiController@index',
    'middleware' => ['optional-auth']
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.iprofile.roles.update',
    'uses' => 'RoleApiController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.iprofile.roles.delete',
    'uses' => 'RoleApiController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.iprofile.roles.show',
    'uses' => 'RoleApiController@show',
  ]);
  
});