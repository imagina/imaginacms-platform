<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'currencies'], function (Router $router) {

  $router->post('/', [
    'as' => 'api.icurrency.currencies.create',
    'uses' => 'CurrencyApiController@create',
    'middleware' => ['auth:api']
  ]);

  $router->get('/', [
    'as' => 'api.icurrency.currencies.index',
    'uses' => 'CurrencyApiController@index',
  ]);

  $router->get('/{criteria}', [
    'as' => 'api.icurrency.currencies.show',
    'uses' => 'CurrencyApiController@show',
  ]);

  $router->put('/{criteria}', [
    'as' => 'api.icurrency.currencies.update',
    'uses' => 'CurrencyApiController@update',
    'middleware' => ['auth:api']
  ]);

  $router->delete('/{criteria}', [
    'as' => 'api.icurrency.currencies.delete',
    'uses' => 'CurrencyApiController@delete',
    'middleware' => ['auth:api']
  ]);

});
