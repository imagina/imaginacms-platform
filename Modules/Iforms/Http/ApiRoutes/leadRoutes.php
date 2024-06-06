<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'leads'], function (Router $router) {

  //Route create
  $router->post('/', [
    'as' => 'api.iforms.leads.create',
    'uses' => 'LeadApiController@create',
    'middleware' => ['captcha']
  ]);

  //Route index
  $router->get('/', [
    'as' => 'api.iforms.leads.get.items.by',
    'uses' => 'LeadApiController@index',
    'middleware' => ['auth:api']
  ]);

  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.iforms.leads.get.item',
    'uses' => 'LeadApiController@show',
    'middleware' => ['auth:api']
  ]);
/*
  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.iforms.leads.update',
    'uses' => 'LeadApiController@update',
    'middleware' => ['auth:api']
  ]);
*/
  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.iforms.leads.delete',
    'uses' => 'LeadApiController@delete',
    'middleware' => ['auth:api']
  ]);
});

