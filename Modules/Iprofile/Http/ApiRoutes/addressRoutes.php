<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/addresses','middleware' => ['auth:api']], function (Router $router) {
  $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
  
  $router->post('/', [
    'as' => $locale . 'api.iprofile.addresses.create',
    'uses' => 'AddressApiController@create',
  ]);
  $router->get('/', [
    'as' => $locale . 'api.iprofile.addresses.index',
    'uses' => 'AddressApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => $locale . 'api.iprofile.addresses.update',
    'uses' => 'AddressApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => $locale . 'api.iprofile.addresses.delete',
    'uses' => 'AddressApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => $locale . 'api.iprofile.addresses.show',
    'uses' => 'AddressApiController@show',
  ]);
  
});