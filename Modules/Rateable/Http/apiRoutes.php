<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/rateable/v1'], function (Router $router) {
    $router->apiCrud([
        'module' => 'rateable',
        'prefix' => 'ratings',
        'controller' => 'RatingApiController',
        //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
    // append
});
