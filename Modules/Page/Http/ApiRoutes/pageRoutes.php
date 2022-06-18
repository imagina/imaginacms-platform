<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'pages'], function (Router $router) {
  //Route create
  $router->post('/', [
    'as' => 'api.ipage.page.create',
    'uses' => 'PageApiController@create',
    'middleware' => ['auth:api']
  ]);

  //Route index
  $router->get('/', [
    'as' => 'api.ipage.page.get.items.by',
    'uses' => 'PageApiController@index',
    'middleware' => ['optional-auth']
  ]);

  //Route index-cms
  $router->get('/cms', [
    'as' => 'api.ipage.page.cms',
    'uses' => 'PageApiController@indexCMS'
  ]);

  //Route show
  $router->get('/{criteria}', [
    'as' => 'api.ipage.page.get.item',
    'uses' => 'PageApiController@show',
    //'middleware' => ['auth:api']
  ]);

  //Route update
  $router->put('/{criteria}', [
    'as' => 'api.ipage.page.update',
    'uses' => 'PageApiController@update',
    'middleware' => ['auth:api']
  ]);

  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'api.ipage.page.delete',
    'uses' => 'PageApiController@delete',
    'middleware' => ['auth:api']
  ]);

});
