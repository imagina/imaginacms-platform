<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/shifts','middleware' => ['auth:api']], function (Router $router) {
  //Route create
  $router->post('/', [
    'as' => 'ichecking.shifts.create',
    'uses' => 'ShiftApiController@create',
  
  ]);
  
  $router->post('/checkin', [
    'as' => 'ichecking.shifts.checkin.create',
    'uses' => 'ShiftApiController@checkin',
  
  ]);
  
  //Route index
  $router->get('/', [
    'as' => 'ichecking.shifts.get.items.by',
    'uses' => 'ShiftApiController@index',
  ]);

  //Route show
  $router->get('/{criteria}', [
    'as' => 'ichecking.shifts.get.item',
    'uses' => 'ShiftApiController@show',
  ]);
  
  //Route update
  $router->put('/checkout/{criteria}', [
    'as' => 'ichecking.shifts.checkout.update',
    'uses' => 'ShiftApiController@checkout',
    'middleware' => ['checkout-can']
  ]);
  
  //Route update
  $router->put('/{criteria}', [
    'as' => 'ichecking.shifts.update',
    'uses' => 'ShiftApiController@update',
  ]);

  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'ichecking.shifts.delete',
    'uses' => 'ShiftApiController@delete',
  ]);
});