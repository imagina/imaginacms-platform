<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => '/ipoint/v1'], function (Router $router) {
    $router->apiCrud([
        'module' => 'ipoint',
        'prefix' => 'points',
        'controller' => 'PointApiController',
        //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
    // append

    //======  PaymentMethod
    require 'ApiRoutes/paymentRoutes.php';
});
