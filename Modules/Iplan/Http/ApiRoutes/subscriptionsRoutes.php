<?php

use Illuminate\Routing\Router;

Route::prefix('subscriptions')->group(function (Router $router) {
    $router->get('/entities', [
        'as' => 'api.iplan.subscriptions.entities',
        'uses' => 'SubscriptionController@entities',
    ]);

    $router->post('/', [
        'as' => 'api.iplan.subscriptions.create',
        'uses' => 'SubscriptionController@create',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/', [
        'as' => 'api.iplan.subscriptions.index',
        'uses' => 'SubscriptionController@index',
    ]);
    $router->get('/me', [
        'as' => 'api.iplan.subscriptions.me',
        'uses' => 'SubscriptionController@me',
        'middleware' => ['auth:api'],
    ]);
    $router->put('/{criteria}', [
        'as' => 'api.iplan.subscriptions.update',
        'uses' => 'SubscriptionController@update',
        'middleware' => ['auth:api'],
    ]);
    $router->delete('/{criteria}', [
        'as' => 'api.iplan.subscriptions.delete',
        'uses' => 'SubscriptionController@delete',
        'middleware' => ['auth:api'],
    ]);
    $router->get('/{criteria}', [
        'as' => 'api.iplan.subscriptions.show',
        'uses' => 'SubscriptionController@show',
    ]);
    $router->post('/buy', [
        'as' => 'api.iplan.subscriptions.buy',
        'uses' => 'SubscriptionController@buy',
        'middleware' => ['auth:api'],
    ]);
});
