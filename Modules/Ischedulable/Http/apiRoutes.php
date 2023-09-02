<?php

use Illuminate\Routing\Router;

Route::prefix('/ischedulable/v1')->group(function (Router $router) {
    $router->apiCrud([
        'module' => 'ischedulable',
        'prefix' => 'days',
        'controller' => 'DayApiController',
        //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
    $router->apiCrud([
        'module' => 'ischedulable',
        'prefix' => 'schedules',
        'controller' => 'ScheduleApiController',
        //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
    $router->apiCrud([
        'module' => 'ischedulable',
        'prefix' => 'worktimes',
        'controller' => 'WorkTimeApiController',
        //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
    // append
});
