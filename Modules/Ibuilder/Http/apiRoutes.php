<?php

use Illuminate\Routing\Router;

$router->group(['prefix' =>'/ibuilder/v1'], function (Router $router) {
    $router->apiCrud([
      'module' => 'ibuilder',
      'prefix' => 'blocks',
      'controller' => 'BlockApiController',
      //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
    $router->apiCrud([
      'module' => 'ibuilder',
      'prefix' => 'templates',
      'controller' => 'TemplateApiController',
      //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
// append


});
