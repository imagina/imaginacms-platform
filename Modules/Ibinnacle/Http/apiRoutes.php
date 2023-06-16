<?php

use Illuminate\Routing\Router;

Route::prefix('/ibinnacle/v1')->group(function (Router $router) {
    $router->apiCrud([
        'module' => 'ibinnacle',
        'prefix' => 'binnacles',
        'controller' => 'BinnacleApiController',
        'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []],
    ]);
    // append
});
