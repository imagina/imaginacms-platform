<?php
use Illuminate\Routing\Router;
$router->group(['prefix' => '/notifications'], function (Router $router) {
  
  //Route create
  $router->post('/', [
    'as' => 'api.notification.create',
    'uses' => 'NotificationApiController@create',
    'middleware' => ['auth:api']
  ]);
  
  //Route index
  $router->get('/', [
    'as' => 'api.notification.get.items.by',
    'uses' => 'NotificationApiController@index',
    'middleware' => ['auth:api']
  ]);
  
  /** @var Router $router */
  $router->put('/mark-read/{id}',
    ['as' => 'api.notification.mark-read',
      'uses' => 'NotificationApiController@markAsRead',
      'middleware' => ['auth:api']
    ]);
  
  
  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.notification.get.item',
    'uses' => 'NotificationApiController@show',
    'middleware' => ['auth:api']
  ]);
  
  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.notification.update',
    'uses' => 'NotificationApiController@update',
    'middleware' => ['auth:api']
  ]);
  
  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.notification.delete',
    'uses' => 'NotificationApiController@delete',
    'middleware' => ['auth:api']
  ]);
  
  //Route update
  $router->put('update-items/{criteria}', [
    'as' => 'api.notification.updateItems',
    'uses' => 'NotificationApiController@updateItems',
    'middleware' => ['auth:api']
  ]);
  
  //Route delete
  $router->delete('delete-items/{criteria}', [
    'as' => 'api.notification.deleteItems',
    'uses' => 'NotificationApiController@deleteItems',
    'middleware' => ['auth:api']
  ]);
});