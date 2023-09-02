<?php

use Illuminate\Routing\Router;

Route::prefix('/comments')->middleware('auth:api')->group(function (Router $router) {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

    $router->post('/', [
        'as' => $locale.'api.ievent.comments.create',
        'uses' => 'CommentApiController@create',
        'middleware' => 'auth-can:ievent.comments.create',
    ]);
    $router->get('/', [
        'as' => $locale.'api.ievent.comments.index',
        'uses' => 'CommentApiController@index',
        'middleware' => 'auth-can:ievent.comments.index',
    ]);
    $router->put('/{criteria}', [
        'as' => $locale.'api.ievent.comments.update',
        'uses' => 'CommentApiController@update',
        'middleware' => 'auth-can:ievent.comments.edit',
    ]);
    $router->delete('/{criteria}', [
        'as' => $locale.'api.ievent.comments.delete',
        'uses' => 'CommentApiController@delete',
        'middleware' => 'auth-can:ievent.comments.destroy',
    ]);
    $router->get('/{criteria}', [
        'as' => $locale.'api.ievent.comments.show',
        'uses' => 'CommentApiController@show',
        'middleware' => 'auth-can:ievent.comments.show',
    ]);
});
