<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('/requestable')->group(function (Router $router) {
    $router->bind('requestable', function ($id) {
        return app('Modules\Requestable\Repositories\RequestableRepository')->find($id);
    });
    $router->get('requestables', [
        'as' => 'admin.requestable.requestable.index',
        'uses' => 'RequestableController@index',
        'middleware' => 'can:requestable.requestables.index',
    ]);
    $router->get('requestables/create', [
        'as' => 'admin.requestable.requestable.create',
        'uses' => 'RequestableController@create',
        'middleware' => 'can:requestable.requestables.create',
    ]);
    $router->post('requestables', [
        'as' => 'admin.requestable.requestable.store',
        'uses' => 'RequestableController@store',
        'middleware' => 'can:requestable.requestables.create',
    ]);
    $router->get('requestables/{requestable}/edit', [
        'as' => 'admin.requestable.requestable.edit',
        'uses' => 'RequestableController@edit',
        'middleware' => 'can:requestable.requestables.edit',
    ]);
    $router->put('requestables/{requestable}', [
        'as' => 'admin.requestable.requestable.update',
        'uses' => 'RequestableController@update',
        'middleware' => 'can:requestable.requestables.edit',
    ]);
    $router->delete('requestables/{requestable}', [
        'as' => 'admin.requestable.requestable.destroy',
        'uses' => 'RequestableController@destroy',
        'middleware' => 'can:requestable.requestables.destroy',
    ]);

    // append
});
