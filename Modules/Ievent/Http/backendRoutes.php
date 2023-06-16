<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::group(['prefix' => '/ievent'], function (Router $router) {
    $router->bind('category', function ($id) {
        return app('Modules\Ievent\Repositories\CategoryRepository')->find($id);
    });
    $router->get('categories', [
        'as' => 'admin.ievent.category.index',
        'uses' => 'CategoryController@index',
        'middleware' => 'can:ievent.categories.index',
    ]);
    $router->get('categories/create', [
        'as' => 'admin.ievent.category.create',
        'uses' => 'CategoryController@create',
        'middleware' => 'can:ievent.categories.create',
    ]);
    $router->post('categories', [
        'as' => 'admin.ievent.category.store',
        'uses' => 'CategoryController@store',
        'middleware' => 'can:ievent.categories.create',
    ]);
    $router->get('categories/{category}/edit', [
        'as' => 'admin.ievent.category.edit',
        'uses' => 'CategoryController@edit',
        'middleware' => 'can:ievent.categories.edit',
    ]);
    $router->put('categories/{category}', [
        'as' => 'admin.ievent.category.update',
        'uses' => 'CategoryController@update',
        'middleware' => 'can:ievent.categories.edit',
    ]);
    $router->delete('categories/{category}', [
        'as' => 'admin.ievent.category.destroy',
        'uses' => 'CategoryController@destroy',
        'middleware' => 'can:ievent.categories.destroy',
    ]);
    $router->bind('recurrenceday', function ($id) {
        return app('Modules\Ievent\Repositories\RecurrenceDayRepository')->find($id);
    });
    $router->get('recurrencedays', [
        'as' => 'admin.ievent.recurrenceday.index',
        'uses' => 'RecurrenceDayController@index',
        'middleware' => 'can:ievent.recurrencedays.index',
    ]);
    $router->get('recurrencedays/create', [
        'as' => 'admin.ievent.recurrenceday.create',
        'uses' => 'RecurrenceDayController@create',
        'middleware' => 'can:ievent.recurrencedays.create',
    ]);
    $router->post('recurrencedays', [
        'as' => 'admin.ievent.recurrenceday.store',
        'uses' => 'RecurrenceDayController@store',
        'middleware' => 'can:ievent.recurrencedays.create',
    ]);
    $router->get('recurrencedays/{recurrenceday}/edit', [
        'as' => 'admin.ievent.recurrenceday.edit',
        'uses' => 'RecurrenceDayController@edit',
        'middleware' => 'can:ievent.recurrencedays.edit',
    ]);
    $router->put('recurrencedays/{recurrenceday}', [
        'as' => 'admin.ievent.recurrenceday.update',
        'uses' => 'RecurrenceDayController@update',
        'middleware' => 'can:ievent.recurrencedays.edit',
    ]);
    $router->delete('recurrencedays/{recurrenceday}', [
        'as' => 'admin.ievent.recurrenceday.destroy',
        'uses' => 'RecurrenceDayController@destroy',
        'middleware' => 'can:ievent.recurrencedays.destroy',
    ]);
    $router->bind('event', function ($id) {
        return app('Modules\Ievent\Repositories\EventRepository')->find($id);
    });
    $router->get('events', [
        'as' => 'admin.ievent.event.index',
        'uses' => 'EventController@index',
        'middleware' => 'can:ievent.events.index',
    ]);
    $router->get('events/create', [
        'as' => 'admin.ievent.event.create',
        'uses' => 'EventController@create',
        'middleware' => 'can:ievent.events.create',
    ]);
    $router->post('events', [
        'as' => 'admin.ievent.event.store',
        'uses' => 'EventController@store',
        'middleware' => 'can:ievent.events.create',
    ]);
    $router->get('events/{event}/edit', [
        'as' => 'admin.ievent.event.edit',
        'uses' => 'EventController@edit',
        'middleware' => 'can:ievent.events.edit',
    ]);
    $router->put('events/{event}', [
        'as' => 'admin.ievent.event.update',
        'uses' => 'EventController@update',
        'middleware' => 'can:ievent.events.edit',
    ]);
    $router->delete('events/{event}', [
        'as' => 'admin.ievent.event.destroy',
        'uses' => 'EventController@destroy',
        'middleware' => 'can:ievent.events.destroy',
    ]);
    $router->bind('recurrence', function ($id) {
        return app('Modules\Ievent\Repositories\RecurrenceRepository')->find($id);
    });
    $router->get('recurrences', [
        'as' => 'admin.ievent.recurrence.index',
        'uses' => 'RecurrenceController@index',
        'middleware' => 'can:ievent.recurrences.index',
    ]);
    $router->get('recurrences/create', [
        'as' => 'admin.ievent.recurrence.create',
        'uses' => 'RecurrenceController@create',
        'middleware' => 'can:ievent.recurrences.create',
    ]);
    $router->post('recurrences', [
        'as' => 'admin.ievent.recurrence.store',
        'uses' => 'RecurrenceController@store',
        'middleware' => 'can:ievent.recurrences.create',
    ]);
    $router->get('recurrences/{recurrence}/edit', [
        'as' => 'admin.ievent.recurrence.edit',
        'uses' => 'RecurrenceController@edit',
        'middleware' => 'can:ievent.recurrences.edit',
    ]);
    $router->put('recurrences/{recurrence}', [
        'as' => 'admin.ievent.recurrence.update',
        'uses' => 'RecurrenceController@update',
        'middleware' => 'can:ievent.recurrences.edit',
    ]);
    $router->delete('recurrences/{recurrence}', [
        'as' => 'admin.ievent.recurrence.destroy',
        'uses' => 'RecurrenceController@destroy',
        'middleware' => 'can:ievent.recurrences.destroy',
    ]);
    $router->bind('attendant', function ($id) {
        return app('Modules\Ievent\Repositories\AttendantRepository')->find($id);
    });
    $router->get('attendants', [
        'as' => 'admin.ievent.attendant.index',
        'uses' => 'AttendantController@index',
        'middleware' => 'can:ievent.attendants.index',
    ]);
    $router->get('attendants/create', [
        'as' => 'admin.ievent.attendant.create',
        'uses' => 'AttendantController@create',
        'middleware' => 'can:ievent.attendants.create',
    ]);
    $router->post('attendants', [
        'as' => 'admin.ievent.attendant.store',
        'uses' => 'AttendantController@store',
        'middleware' => 'can:ievent.attendants.create',
    ]);
    $router->get('attendants/{attendant}/edit', [
        'as' => 'admin.ievent.attendant.edit',
        'uses' => 'AttendantController@edit',
        'middleware' => 'can:ievent.attendants.edit',
    ]);
    $router->put('attendants/{attendant}', [
        'as' => 'admin.ievent.attendant.update',
        'uses' => 'AttendantController@update',
        'middleware' => 'can:ievent.attendants.edit',
    ]);
    $router->delete('attendants/{attendant}', [
        'as' => 'admin.ievent.attendant.destroy',
        'uses' => 'AttendantController@destroy',
        'middleware' => 'can:ievent.attendants.destroy',
    ]);
    $router->bind('comment', function ($id) {
        return app('Modules\Ievent\Repositories\CommentRepository')->find($id);
    });
    $router->get('comments', [
        'as' => 'admin.ievent.comment.index',
        'uses' => 'CommentController@index',
        'middleware' => 'can:ievent.comments.index',
    ]);
    $router->get('comments/create', [
        'as' => 'admin.ievent.comment.create',
        'uses' => 'CommentController@create',
        'middleware' => 'can:ievent.comments.create',
    ]);
    $router->post('comments', [
        'as' => 'admin.ievent.comment.store',
        'uses' => 'CommentController@store',
        'middleware' => 'can:ievent.comments.create',
    ]);
    $router->get('comments/{comment}/edit', [
        'as' => 'admin.ievent.comment.edit',
        'uses' => 'CommentController@edit',
        'middleware' => 'can:ievent.comments.edit',
    ]);
    $router->put('comments/{comment}', [
        'as' => 'admin.ievent.comment.update',
        'uses' => 'CommentController@update',
        'middleware' => 'can:ievent.comments.edit',
    ]);
    $router->delete('comments/{comment}', [
        'as' => 'admin.ievent.comment.destroy',
        'uses' => 'CommentController@destroy',
        'middleware' => 'can:ievent.comments.destroy',
    ]);
    // append
});
