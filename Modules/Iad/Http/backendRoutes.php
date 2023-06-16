<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::group(['prefix' => '/iad'], function (Router $router) {
    $router->bind('category', function ($id) {
        return app('Modules\Iad\Repositories\CategoryRepository')->find($id);
    });
    $router->get('categories', [
        'as' => 'admin.iad.category.index',
        'uses' => 'CategoryController@index',
        'middleware' => 'can:iad.categories.index',
    ]);
    $router->get('categories/create', [
        'as' => 'admin.iad.category.create',
        'uses' => 'CategoryController@create',
        'middleware' => 'can:iad.categories.create',
    ]);
    $router->post('categories', [
        'as' => 'admin.iad.category.store',
        'uses' => 'CategoryController@store',
        'middleware' => 'can:iad.categories.create',
    ]);
    $router->get('categories/{category}/edit', [
        'as' => 'admin.iad.category.edit',
        'uses' => 'CategoryController@edit',
        'middleware' => 'can:iad.categories.edit',
    ]);
    $router->put('categories/{category}', [
        'as' => 'admin.iad.category.update',
        'uses' => 'CategoryController@update',
        'middleware' => 'can:iad.categories.edit',
    ]);
    $router->delete('categories/{category}', [
        'as' => 'admin.iad.category.destroy',
        'uses' => 'CategoryController@destroy',
        'middleware' => 'can:iad.categories.destroy',
    ]);
    $router->bind('ad', function ($id) {
        return app('Modules\Iad\Repositories\AdRepository')->find($id);
    });
    $router->get('ads', [
        'as' => 'admin.iad.ad.index',
        'uses' => 'AdController@index',
        'middleware' => 'can:iad.ads.index',
    ]);
    $router->get('ads/create', [
        'as' => 'admin.iad.ad.create',
        'uses' => 'AdController@create',
        'middleware' => 'can:iad.ads.create',
    ]);
    $router->post('ads', [
        'as' => 'admin.iad.ad.store',
        'uses' => 'AdController@store',
        'middleware' => 'can:iad.ads.create',
    ]);
    $router->get('ads/{ad}/edit', [
        'as' => 'admin.iad.ad.edit',
        'uses' => 'AdController@edit',
        'middleware' => 'can:iad.ads.edit',
    ]);
    $router->put('ads/{ad}', [
        'as' => 'admin.iad.ad.update',
        'uses' => 'AdController@update',
        'middleware' => 'can:iad.ads.edit',
    ]);
    $router->delete('ads/{ad}', [
        'as' => 'admin.iad.ad.destroy',
        'uses' => 'AdController@destroy',
        'middleware' => 'can:iad.ads.destroy',
    ]);
    $router->bind('field', function ($id) {
        return app('Modules\Iad\Repositories\FieldRepository')->find($id);
    });
    $router->get('fields', [
        'as' => 'admin.iad.field.index',
        'uses' => 'FieldController@index',
        'middleware' => 'can:iad.fields.index',
    ]);
    $router->get('fields/create', [
        'as' => 'admin.iad.field.create',
        'uses' => 'FieldController@create',
        'middleware' => 'can:iad.fields.create',
    ]);
    $router->post('fields', [
        'as' => 'admin.iad.field.store',
        'uses' => 'FieldController@store',
        'middleware' => 'can:iad.fields.create',
    ]);
    $router->get('fields/{field}/edit', [
        'as' => 'admin.iad.field.edit',
        'uses' => 'FieldController@edit',
        'middleware' => 'can:iad.fields.edit',
    ]);
    $router->put('fields/{field}', [
        'as' => 'admin.iad.field.update',
        'uses' => 'FieldController@update',
        'middleware' => 'can:iad.fields.edit',
    ]);
    $router->delete('fields/{field}', [
        'as' => 'admin.iad.field.destroy',
        'uses' => 'FieldController@destroy',
        'middleware' => 'can:iad.fields.destroy',
    ]);
    $router->bind('schedule', function ($id) {
        return app('Modules\Iad\Repositories\ScheduleRepository')->find($id);
    });
    $router->get('schedules', [
        'as' => 'admin.iad.schedule.index',
        'uses' => 'ScheduleController@index',
        'middleware' => 'can:iad.schedules.index',
    ]);
    $router->get('schedules/create', [
        'as' => 'admin.iad.schedule.create',
        'uses' => 'ScheduleController@create',
        'middleware' => 'can:iad.schedules.create',
    ]);
    $router->post('schedules', [
        'as' => 'admin.iad.schedule.store',
        'uses' => 'ScheduleController@store',
        'middleware' => 'can:iad.schedules.create',
    ]);
    $router->get('schedules/{schedule}/edit', [
        'as' => 'admin.iad.schedule.edit',
        'uses' => 'ScheduleController@edit',
        'middleware' => 'can:iad.schedules.edit',
    ]);
    $router->put('schedules/{schedule}', [
        'as' => 'admin.iad.schedule.update',
        'uses' => 'ScheduleController@update',
        'middleware' => 'can:iad.schedules.edit',
    ]);
    $router->delete('schedules/{schedule}', [
        'as' => 'admin.iad.schedule.destroy',
        'uses' => 'ScheduleController@destroy',
        'middleware' => 'can:iad.schedules.destroy',
    ]);
    $router->bind('ups', function ($id) {
        return app('Modules\Iad\Repositories\UpRepository')->find($id);
    });
    $router->get('ups', [
        'as' => 'admin.iad.ups.index',
        'uses' => 'UpsController@index',
        'middleware' => 'can:iad.ups.index',
    ]);
    $router->get('ups/create', [
        'as' => 'admin.iad.ups.create',
        'uses' => 'UpsController@create',
        'middleware' => 'can:iad.ups.create',
    ]);
    $router->post('ups', [
        'as' => 'admin.iad.ups.store',
        'uses' => 'UpsController@store',
        'middleware' => 'can:iad.ups.create',
    ]);
    $router->get('ups/{ups}/edit', [
        'as' => 'admin.iad.ups.edit',
        'uses' => 'UpsController@edit',
        'middleware' => 'can:iad.ups.edit',
    ]);
    $router->put('ups/{ups}', [
        'as' => 'admin.iad.ups.update',
        'uses' => 'UpsController@update',
        'middleware' => 'can:iad.ups.edit',
    ]);
    $router->delete('ups/{ups}', [
        'as' => 'admin.iad.ups.destroy',
        'uses' => 'UpsController@destroy',
        'middleware' => 'can:iad.ups.destroy',
    ]);
    $router->bind('adup', function ($id) {
        return app('Modules\Iad\Repositories\AdUpRepository')->find($id);
    });
    $router->get('adups', [
        'as' => 'admin.iad.adup.index',
        'uses' => 'AdUpController@index',
        'middleware' => 'can:iad.adups.index',
    ]);
    $router->get('adups/create', [
        'as' => 'admin.iad.adup.create',
        'uses' => 'AdUpController@create',
        'middleware' => 'can:iad.adups.create',
    ]);
    $router->post('adups', [
        'as' => 'admin.iad.adup.store',
        'uses' => 'AdUpController@store',
        'middleware' => 'can:iad.adups.create',
    ]);
    $router->get('adups/{adup}/edit', [
        'as' => 'admin.iad.adup.edit',
        'uses' => 'AdUpController@edit',
        'middleware' => 'can:iad.adups.edit',
    ]);
    $router->put('adups/{adup}', [
        'as' => 'admin.iad.adup.update',
        'uses' => 'AdUpController@update',
        'middleware' => 'can:iad.adups.edit',
    ]);
    $router->delete('adups/{adup}', [
        'as' => 'admin.iad.adup.destroy',
        'uses' => 'AdUpController@destroy',
        'middleware' => 'can:iad.adups.destroy',
    ]);
    $router->bind('uplog', function ($id) {
        return app('Modules\Iad\Repositories\UpLogRepository')->find($id);
    });
    $router->get('uplogs', [
        'as' => 'admin.iad.uplog.index',
        'uses' => 'UpLogController@index',
        'middleware' => 'can:iad.uplogs.index',
    ]);
    $router->get('uplogs/create', [
        'as' => 'admin.iad.uplog.create',
        'uses' => 'UpLogController@create',
        'middleware' => 'can:iad.uplogs.create',
    ]);
    $router->post('uplogs', [
        'as' => 'admin.iad.uplog.store',
        'uses' => 'UpLogController@store',
        'middleware' => 'can:iad.uplogs.create',
    ]);
    $router->get('uplogs/{uplog}/edit', [
        'as' => 'admin.iad.uplog.edit',
        'uses' => 'UpLogController@edit',
        'middleware' => 'can:iad.uplogs.edit',
    ]);
    $router->put('uplogs/{uplog}', [
        'as' => 'admin.iad.uplog.update',
        'uses' => 'UpLogController@update',
        'middleware' => 'can:iad.uplogs.edit',
    ]);
    $router->delete('uplogs/{uplog}', [
        'as' => 'admin.iad.uplog.destroy',
        'uses' => 'UpLogController@destroy',
        'middleware' => 'can:iad.uplogs.destroy',
    ]);
    // append
});
