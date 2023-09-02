<?php

use Illuminate\Routing\Router;

Route::prefix('entity-plans')->group(function (Router $router) {
    $router->post('/', [
        'as' => 'api.iplan.entityPlans.create',
        'uses' => 'EntityPlanController@create',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/', [
        'as' => 'api.iplan.entityPlans.index',
        'uses' => 'EntityPlanController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.iplan.entityPlans.update',
        'uses' => 'EntityPlanController@update',
        'middleware' => ['auth:api'],
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.iplan.entityPlans.delete',
        'uses' => 'EntityPlanController@delete',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.iplan.entityPlans.show',
        'uses' => 'EntityPlanController@show',
    ]);
});
