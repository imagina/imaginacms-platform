<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/settings','middleware' => ['auth:api']], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.iprofile.settings.create',
    'uses' => 'SettingApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.iprofile.settings.index',
    'uses' => 'SettingApiController@index',
  ]);
  
  $router->get('/settings', [
    'as' => 'api.iprofile.settings.settings',
    'uses' => 'SettingApiController@getSettings',
    'middleware' => ['auth:api']
  ]);
  
  $router->put('/{criteria}', [
    'as' => $locale . 'api.iprofile.settings.update',
    'uses' => 'SettingApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.iprofile.settings.delete',
    'uses' => 'SettingApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.iprofile.settings.show',
    'uses' => 'SettingApiController@show',
  ]);
  
});
