<?php

use Illuminate\Routing\Router;

Route::prefix('/icomments/v1')->group(function (Router $router) {
    $router->apiCrud([
        'module' => 'icomments',
        'prefix' => 'comments',
        'controller' => 'CommentApiController',
        //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
    // append
});
