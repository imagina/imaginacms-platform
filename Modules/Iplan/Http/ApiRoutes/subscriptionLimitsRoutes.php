<?php

use Illuminate\Routing\Router;

Route::prefix('subscription-limits')->group(function (Router $router) {
    $router->post('/', [
        'as' => 'api.iplan.subscriptionlimits.create',
        'uses' => 'SubscriptionLimitController@create',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/', [
        'as' => 'api.iplan.subscriptionlimits.index',
        'uses' => 'SubscriptionLimitController@index',
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.iplan.subscriptionlimits.update',
        'uses' => 'SubscriptionLimitController@update',
        'middleware' => ['auth:api'],
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.iplan.subscriptionlimits.delete',
        'uses' => 'SubscriptionLimitController@delete',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.iplan.subscriptionlimits.show',
        'uses' => 'SubscriptionLimitController@show',
    ]);
});
