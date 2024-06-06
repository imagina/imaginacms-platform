<?php
use Illuminate\Routing\Router;
$router->group(['prefix' => '/providers'], function (Router $router) {
  
  //Route create
  $router->post('/', [
    'as' => 'api.notification.create',
    'uses' => 'ProviderApiController@create',
    'middleware' => ['auth:api']
  ]);
  
  //Route index
  $router->get('/', [
    'as' => 'api.notification.get.items.by',
    'uses' => 'ProviderApiController@index',
    'middleware' => ['auth:api']
  ]);
  
  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.notification.get.item',
    'uses' => 'ProviderApiController@show',
    'middleware' => ['auth:api']
  ]);
  
  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.notification.update',
    'uses' => 'ProviderApiController@update',
    'middleware' => ['auth:api']
  ]);
  
  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.notification.delete',
    'uses' => 'ProviderApiController@delete',
    'middleware' => ['auth:api']
  ]);
  
  
});