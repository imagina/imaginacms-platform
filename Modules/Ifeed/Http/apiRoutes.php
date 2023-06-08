<?php

use Illuminate\Routing\Router;

$router->group(['prefix' =>'/ifeed/v1'], function (Router $router) {
    $router->apiCrud([
      'module' => 'ifeed',
      'prefix' => 'feeds',
      'controller' => 'FeedApiController',
      //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
// append

});
