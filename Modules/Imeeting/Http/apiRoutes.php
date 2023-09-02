<?php

use Illuminate\Routing\Router;

Route::prefix('/imeeting/v1')->group(function (Router $router) {
    $router->apiCrud([
        'module' => 'imeeting',
        'prefix' => 'meetings',
        'controller' => 'MeetingApiController',
        'middleware' => ['create' => [], 'index' => []], // Just Testing
    ]);

    $router->apiCrud([
        'module' => 'imeeting',
        'prefix' => 'providers',
        'controller' => 'ProviderApiController',
        'middleware' => [],
    ]);
    // append
});
