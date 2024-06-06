<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'fields'], function (Router $router) {

  //Route create
  $router->post('/', [
    'as' => 'api.iforms.fields.create',
    'uses' => 'FieldApiController@create',
    'middleware' => ['auth:api']
  ]);

  //Route index
  $router->get('/', [
    'as' => 'api.iforms.fields.get.items.by',
    'uses' => 'FieldApiController@index',
    //'middleware' => ['auth:api']
  ]);

  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.iforms.fields.get.item',
    'uses' => 'FieldApiController@show',
    //'middleware' => ['auth:api']
  ]);

  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.iforms.fields.update',
    'uses' => 'FieldApiController@update',
    'middleware' => ['auth:api']
  ]);

  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.iforms.fields.delete',
    'uses' => 'FieldApiController@delete',
    //'middleware' => ['auth:api']
  ]);

  //Route update
  $router->post('/updateOrders', [
    'as' => 'api.iforms.fields.updateOrders',
    'uses' => 'FieldApiController@updateOrders',
    'middleware' => ['auth:api']
  ]);

});
