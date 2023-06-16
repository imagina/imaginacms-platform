<?php

use Illuminate\Routing\Router;

Route::prefix('/ifillable/v1')->group(function (Router $router) {
    $router->apiCrud([
        'module' => 'ifillable',
        'prefix' => 'fields',
        'controller' => 'FieldApiController',
        //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
    // append
});
