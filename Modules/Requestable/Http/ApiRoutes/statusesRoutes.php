<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/statuses'], function (Router $router) {
 

  $router->post('/order-status', [
    'as' => 'statuses.order.status',
    'uses' => 'StatusApiController@updateOrderStatus',
    'middleware' => ['auth:api','auth-can:requestable.statuses.edit']
  ]);


  
});