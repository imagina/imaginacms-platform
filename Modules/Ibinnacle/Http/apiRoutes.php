<?php

use Illuminate\Routing\Router;

Route::group(['prefix' =>'/ibinnacle/v1'], function (Router $router) {
    $router->apiCrud([
        'module' => 'ibinnacle',
        'prefix' => 'binnacles',
        'controller' => 'BinnacleApiController',
        'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []],
    ]);
    // append
});
