<?php

use Illuminate\Routing\Router;

$router->group(['prefix' =>'/ifillable/v1'], function (Router $router) {
    $router->apiCrud([
      'module' => 'ifillable',
      'prefix' => 'fields',
      'controller' => 'FieldApiController',
      //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
// append

});
