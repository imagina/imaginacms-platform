<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/departments','middleware' => ['auth:api']], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.iprofile.departments.create',
    'uses' => 'DepartmentApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.iprofile.departments.index',
    'uses' => 'DepartmentApiController@index',
  ]);
  
  $router->get('/settings', [
    'as' => 'api.iprofile.departments.settings',
    'uses' => 'DepartmentApiController@getSettings'
  ]);
  
  $router->put('/{criteria}', [
    'as' => $locale . 'api.iprofile.departments.update',
    'uses' => 'DepartmentApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.iprofile.departments.delete',
    'uses' => 'DepartmentApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.iprofile.departments.show',
    'uses' => 'DepartmentApiController@show',
  ]);
  
});
