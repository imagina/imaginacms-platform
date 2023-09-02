<?php

use Illuminate\Routing\Router;

Route::prefix('/ifollow/v1')->group(function (Router $router) {
    $router->apiCrud([
        'module' => 'ifollow',
        'prefix' => 'followers',
        'controller' => 'FollowerApiController',
        'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []],
    ]);
    // append
});
