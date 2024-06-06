<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/roles','middleware' => ['auth:api']], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.iprofile.roles.create',
    'uses' => 'RoleApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.iprofile.roles.index',
    'uses' => 'RoleApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.iprofile.roles.update',
    'uses' => 'RoleApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.iprofile.roles.delete',
    'uses' => 'RoleApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.iprofile.roles.show',
    'uses' => 'RoleApiController@show',
  ]);
  
});