<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/approvals','middleware' => ['auth:api']], function (Router $router) {
  //Route create
  $router->post('/', [
    'as' => 'ichecking.approvals.create',
    'uses' => 'ApprovalApiController@create',
  
  ]);
  
  //Route index
  $router->get('/', [
    'as' => 'ichecking.approvals.get.items.by',
    'uses' => 'ApprovalApiController@index',
  ]);
  
  //Route index
  $router->get('/by-shifts', [
    'as' => 'ichecking.approvals.by-shifts.by',
    'uses' => 'ApprovalApiController@byShifts',
  ]);
  
  
  //Route index
  $router->get('/by-shifts/export', [
    'as' => 'ichecking.approvals.by-shifts-report.by',
    'uses' => 'ApprovalApiController@byShiftsReport',
  ]);
  
  
  //Route show
  $router->get('/{criteria}', [
    'as' => 'ichecking.approvals.get.item',
    'uses' => 'ApprovalApiController@show',
  ]);
 
  //Route update
  $router->put('/{criteria}', [
    'as' => 'ichecking.approvals.update',
    'uses' => 'ApprovalApiController@update',
  ]);

  //Route delete
  $router->delete('/{criteria}', [
    'as' => 'ichecking.approvals.delete',
    'uses' => 'ApprovalApiController@delete',
  ]);
});