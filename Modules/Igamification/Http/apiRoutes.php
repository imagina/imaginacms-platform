<?php

use Illuminate\Routing\Router;

$router->group(['prefix' =>'/igamification/v1'], function (Router $router) {
    $router->apiCrud([
      'module' => 'igamification',
      'prefix' => 'categories',
      'controller' => 'CategoryApiController',
      //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
    $router->apiCrud([
      'module' => 'igamification',
      'prefix' => 'activities',
      'controller' => 'ActivityApiController',
      //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
// append


});
