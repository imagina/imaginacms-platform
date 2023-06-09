<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/icomments/v1'], function (Router $router) {
    $router->apiCrud([
        'module' => 'icomments',
        'prefix' => 'comments',
        'controller' => 'CommentApiController',
        //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
    // append
});
