<?php

use Illuminate\Routing\Router;

Route::prefix('plans')->group(function (Router $router) {
    $router->get('/modules', [
        'as' => 'api.iplan.plans.modules',
        'uses' => 'PlanController@modules',
    ]);

    $router->get('/frequencies', [
        'as' => 'api.iplan.plans.frequencies',
        'uses' => 'PlanApiController@frequencies',
    ]);
});
