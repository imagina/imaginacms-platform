<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('/imeeting')->group(function (Router $router) {
    $router->bind('imeeting', function ($id) {
        return app('Modules\Imeeting\Repositories\MeetingRepository')->find($id);
    });
    $router->get('imeetings', [
        'as' => 'admin.imeeting.imeeting.index',
        'uses' => 'MeetingController@index',
        'middleware' => 'can:imeeting.imeetings.index',
    ]);
    $router->get('imeetings/create', [
        'as' => 'admin.imeeting.imeeting.create',
        'uses' => 'MeetingController@create',
        'middleware' => 'can:imeeting.imeetings.create',
    ]);
    $router->post('imeetings', [
        'as' => 'admin.imeeting.imeeting.store',
        'uses' => 'MeetingController@store',
        'middleware' => 'can:imeeting.imeetings.create',
    ]);
    $router->get('imeetings/{imeeting}/edit', [
        'as' => 'admin.imeeting.imeeting.edit',
        'uses' => 'MeetingController@edit',
        'middleware' => 'can:imeeting.imeetings.edit',
    ]);
    $router->put('imeetings/{id}', [
        'as' => 'admin.imeeting.imeeting.update',
        'uses' => 'MeetingController@update',
        'middleware' => 'can:imeeting.imeetings.edit',
    ]);
    $router->delete('imeetings/{imeeting}', [
        'as' => 'admin.imeeting.imeeting.destroy',
        'uses' => 'MeetingController@destroy',
        'middleware' => 'can:imeeting.imeetings.destroy',
    ]);
    // append
});
