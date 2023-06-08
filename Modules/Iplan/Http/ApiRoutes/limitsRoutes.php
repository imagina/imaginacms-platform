<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => 'limits'], function (Router $router) {

  $router->get('/entities', [
    'as' => 'api.iplan.limits.entities',
    'uses' => 'LimitController@entities',
  ]);
  $router->post('/', [
    'as' => 'api.iplan.limits.create',
    'uses' => 'LimitController@create',
    'middleware' => ['auth:api']
  ]);
  $router->get('/', [
    'as' => 'api.iplan.limits.index',
    'uses' => 'LimitController@index',
  ]);
  $router->put('/{criteria}', [
    'as' => 'api.iplan.limits.update',
    'uses' => 'LimitController@update',
    'middleware' => ['auth:api']
  ]);
  $router->delete('/{criteria}', [
    'as' => 'api.iplan.limits.delete',
    'uses' => 'LimitController@delete',
    'middleware' => ['auth:api']
  ]);
  $router->get('/{criteria}', [
    'as' => 'api.iplan.limits.show',
    'uses' => 'LimitController@show',
  ]);

});
