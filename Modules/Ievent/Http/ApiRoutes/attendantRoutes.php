<?php

use Illuminate\Routing\Router;

Route::prefix('/attendants')->middleware('auth:api')->group(function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->post('/', [
        'as' => $locale.'api.ievent.attendants.create',
        'uses' => 'AttendantApiController@create',
        'middleware' => 'auth-can:ievent.attendants.create',
    ]);
    $router->get('/', [
        'as' => $locale.'api.ievent.attendants.index',
        'uses' => 'AttendantApiController@index',
        'middleware' => 'auth-can:ievent.attendants.index',
    ]);
    $router->put('/{criteria}', [
        'as' => $locale.'api.ievent.attendants.update',
        'uses' => 'AttendantApiController@update',
        'middleware' => 'auth-can:ievent.attendants.edit',
    ]);
    $router->delete('/{criteria}', [
        'as' => $locale.'api.ievent.attendants.delete',
        'uses' => 'AttendantApiController@delete',
        'middleware' => 'auth-can:ievent.attendants.destroy',
    ]);
    $router->get('/{criteria}', [
        'as' => $locale.'api.ievent.attendants.show',
        'uses' => 'AttendantApiController@show',
        'middleware' => 'auth-can:ievent.attendants.show',
    ]);
});
