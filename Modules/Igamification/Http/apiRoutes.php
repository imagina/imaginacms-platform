<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/igamification/v1'], function (Router $router) {
  $router->apiCrud([
    'module' => 'igamification',
    'prefix' => 'categories',
    'controller' => 'CategoryApiController',
    'middleware' => ['index' => ['optional-auth'], 'show' => ['optional-auth']]
  ]);
  $router->apiCrud([
    'module' => 'igamification',
    'prefix' => 'activities',
    'controller' => 'ActivityApiController',
    'middleware' => ['index' => [], 'show' => []]
  ]);
  $router->apiCrud([
    'module' => 'igamification',
    'prefix' => 'statuses',
    'staticEntity' => 'Modules\Igamification\Entities\Status',
    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
  ]);
  $router->group(['prefix' => 'activity-user'], function (Router $router) {
    $router->get('/', [
      'as' => 'api.igamification.activity-user.get.items.by',
      'uses' => 'ActivityUserApiController@index',
      'middleware' => ['auth:api']
    ]);
  });
  $router->apiCrud([
    'module' => 'igamification',
    'prefix' => 'types',
    'staticEntity' => 'Modules\Igamification\Entities\Type',
    //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
  ]);
  // append
});
