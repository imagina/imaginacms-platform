<?php

use Illuminate\Routing\Router;

$locale = LaravelLocalization::setLocale() ?: App::getLocale();

/** @var Router $router */
Route::prefix(LaravelLocalization::setLocale())->middleware('localize')->group(function (Router $router) use ($locale) {
    $router->get(trans('iplan::routes.plan.index'), [
        'as' => $locale.'.iplan.plan.index',
        'uses' => 'PublicController@index',
    ]);

    $router->get(trans('iplan::routes.plan.indexCategory'), [
        'as' => $locale.'.iplan.plan.indexCategory',
        'uses' => 'PublicController@indexCategory',
    ]);

    $router->get(trans('iplan::routes.plan.index').'/{planId}/'.trans('iplan::routes.plan.buy'), [
        'as' => 'plans.buy',
        'uses' => 'PublicController@buyPlan',
        'middleware' => 'doNotCacheResponse',
    ]);

    $router->post(trans('iplan::routes.plan.index').'/'.trans('iplan::routes.plan.buy'), [
        'as' => 'plans.buyPlan',
        'uses' => 'PublicController@buyPlan',
    ]);
    $router->get('iplan/validate-subscription/{criteria}', [
        'as' => 'plans.validateUserSubscriptions',
        'uses' => 'PublicController@validateUserSubscription',
    ]);
    $router->get(trans('iplan::routes.plan.my-subscriptions'), [
        'as' => 'plans.mySubscriptions',
        'uses' => 'PublicController@mySubscriptions',
        'middleware' => 'logged.in',
    ]);
});
