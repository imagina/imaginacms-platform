<?php

use Illuminate\Routing\Router;

Route::prefix('/ifeed/v1')->group(function (Router $router) {
    $router->apiCrud([
        'module' => 'ifeed',
        'prefix' => 'feeds',
        'controller' => 'FeedApiController',
        //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
    // append
});
