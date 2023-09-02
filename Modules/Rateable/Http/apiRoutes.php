<?php

use Illuminate\Routing\Router;

Route::prefix('/rateable/v1')->group(function (Router $router) {
    $router->apiCrud([
        'module' => 'rateable',
        'prefix' => 'ratings',
        'controller' => 'RatingApiController',
        //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
    // append
});
