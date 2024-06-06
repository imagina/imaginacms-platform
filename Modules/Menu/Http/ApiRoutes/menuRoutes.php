<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'menu'], function (Router $router) {
  $router->post('/', [
    'as' => 'api.imenu.menu.create',
    //'middleware' => ['auth:api'],
    'uses' => 'MenuApiController@create',
  ]);
  $router->get('/', [
    'as' => 'api.imenu.menu.index',
    'uses' => 'MenuApiController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => 'api.imenu.menu.update',
    //'middleware' => ['auth:api'],
    'uses' => 'MenuApiController@update',
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.imenu.menu.delete',
    //'middleware' => ['auth:api'],
    'uses' => 'MenuApiController@delete',
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.imenu.menu.show',
    'uses' => 'MenuApiController@show',
  ]);
});
