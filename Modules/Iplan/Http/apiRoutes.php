<?php

use Illuminate\Routing\Router;

Route::prefix('iplan/v1')->group(function (Router $router) {
    //======  CATEGORIES
    require 'ApiRoutes/categoriesRoutes.php';
    //======  PLANS
    require 'ApiRoutes/plansRoutes.php';
    //======  ENTITY PLANS
    require 'ApiRoutes/entityPlansRoutes.php';
    //======  LIMITS
    require 'ApiRoutes/limitsRoutes.php';

    //======  SUBSCRIPTIONS
    require 'ApiRoutes/subscriptionsRoutes.php';
    //======  SUBSCRIPTION LIMITS
    require 'ApiRoutes/subscriptionLimitsRoutes.php';

    $router->apiCrud([
        'module' => 'iplan',
        'prefix' => 'plans',
        'controller' => 'PlanApiController',
        'middleware' => ['index' => ['optional-auth'], 'create' => ['auth:api'], 'update' => ['auth:api'], ' delete' => ['auth:api']], // Just Testing
    ]);

    $router->apiCrud([
        'module' => 'iplan',
        'prefix' => 'statuses',
        'staticEntity' => 'Modules\Iplan\Entities\Status',
        //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);

    $router->apiCrud([
        'module' => 'iplan',
        'prefix' => 'types',
        'staticEntity' => 'Modules\Iplan\Entities\PlanType',
        //'middleware' => ['create' => [], 'index' => [], 'show' => [], 'update' => [], 'delete' => [], 'restore' => []]
    ]);
});
