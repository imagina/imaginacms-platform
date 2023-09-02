<?php

use Illuminate\Routing\Router;

Route::prefix('/recurrences')->middleware('auth:api')->group(function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->post('/', [
        'as' => $locale.'api.ievent.recurrences.create',
        'uses' => 'RecurrenceApiController@create',
        'middleware' => 'auth-can:ievent.recurrences.create',
    ]);
    $router->get('/', [
        'as' => $locale.'api.ievent.recurrences.index',
        'uses' => 'RecurrenceApiController@index',
        'middleware' => 'auth-can:ievent.recurrences.index',
    ]);
    $router->put('/{criteria}', [
        'as' => $locale.'api.ievent.recurrences.update',
        'uses' => 'RecurrenceApiController@update',
        'middleware' => 'auth-can:ievent.recurrences.edit',
    ]);
    $router->delete('/{criteria}', [
        'as' => $locale.'api.ievent.recurrences.delete',
        'uses' => 'RecurrenceApiController@delete',
        'middleware' => 'auth-can:ievent.recurrences.destroy',
    ]);
    $router->get('/{criteria}', [
        'as' => $locale.'api.ievent.recurrences.show',
        'uses' => 'RecurrenceApiController@show',
        'middleware' => 'auth-can:ievent.recurrences.show',
    ]);
});
