<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::middleware('localize')->group(function (Router $router) {
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();

    $router->get(trans('idocs::routes.documents.index.publicDocuments'), [
        'as' => $locale.'.idocs.index.public',
        'uses' => 'PublicController@index',
    ]);

    $router->get(trans('idocs::routes.documents.index.privateDocuments'), [
        'as' => $locale.'.idocs.index.private',
        'uses' => 'PublicController@indexPrivate',
        'middleware' => 'logged.in',
    ]);

    $router->get(trans('idocs::routes.documents.index.publicCategory'), [
        'as' => $locale.'.idocs.index.public.category',
        'uses' => 'PublicController@index',
    ]);

    $router->get(trans('idocs::routes.documents.index.privateCategory'), [
        'as' => $locale.'.idocs.index.private.category',
        'uses' => 'PublicController@indexPrivate',
        'middleware' => 'logged.in',
    ]);

    $router->get(trans('idocs::routes.documents.show.document'), [
        'as' => $locale.'.idocs.show.document',
        'uses' => 'PublicController@show',
        'middleware' => 'optional-auth',
    ]);
    $router->get(trans('idocs::routes.documents.show.documentByKey'), [
        'as' => $locale.'.idocs.show.documentByKey',
        'uses' => 'PublicController@showByKey',
    ]);
});
