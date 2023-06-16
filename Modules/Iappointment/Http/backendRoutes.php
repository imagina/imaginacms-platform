<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::group(['prefix' => '/iappointment'], function (Router $router) {
    $router->bind('appointment', function ($id) {
        return app('Modules\Iappointment\Repositories\AppointmentRepository')->find($id);
    });
    $router->get('appointments', [
        'as' => 'admin.iappointment.appointment.index',
        'uses' => 'AppointmentController@index',
        'middleware' => 'can:iappointment.appointments.index',
    ]);
    $router->get('appointments/create', [
        'as' => 'admin.iappointment.appointment.create',
        'uses' => 'AppointmentController@create',
        'middleware' => 'can:iappointment.appointments.create',
    ]);
    $router->post('appointments', [
        'as' => 'admin.iappointment.appointment.store',
        'uses' => 'AppointmentController@store',
        'middleware' => 'can:iappointment.appointments.create',
    ]);
    $router->get('appointments/{appointment}/edit', [
        'as' => 'admin.iappointment.appointment.edit',
        'uses' => 'AppointmentController@edit',
        'middleware' => 'can:iappointment.appointments.edit',
    ]);
    $router->put('appointments/{appointment}', [
        'as' => 'admin.iappointment.appointment.update',
        'uses' => 'AppointmentController@update',
        'middleware' => 'can:iappointment.appointments.edit',
    ]);
    $router->delete('appointments/{appointment}', [
        'as' => 'admin.iappointment.appointment.destroy',
        'uses' => 'AppointmentController@destroy',
        'middleware' => 'can:iappointment.appointments.destroy',
    ]);
    $router->bind('category', function ($id) {
        return app('Modules\Iappointment\Repositories\CategoryRepository')->find($id);
    });
    $router->get('categories', [
        'as' => 'admin.iappointment.category.index',
        'uses' => 'CategoryController@index',
        'middleware' => 'can:iappointment.categories.index',
    ]);
    $router->get('categories/create', [
        'as' => 'admin.iappointment.category.create',
        'uses' => 'CategoryController@create',
        'middleware' => 'can:iappointment.categories.create',
    ]);
    $router->post('categories', [
        'as' => 'admin.iappointment.category.store',
        'uses' => 'CategoryController@store',
        'middleware' => 'can:iappointment.categories.create',
    ]);
    $router->get('categories/{category}/edit', [
        'as' => 'admin.iappointment.category.edit',
        'uses' => 'CategoryController@edit',
        'middleware' => 'can:iappointment.categories.edit',
    ]);
    $router->put('categories/{category}', [
        'as' => 'admin.iappointment.category.update',
        'uses' => 'CategoryController@update',
        'middleware' => 'can:iappointment.categories.edit',
    ]);
    $router->delete('categories/{category}', [
        'as' => 'admin.iappointment.category.destroy',
        'uses' => 'CategoryController@destroy',
        'middleware' => 'can:iappointment.categories.destroy',
    ]);
    $router->bind('appointmentfield', function ($id) {
        return app('Modules\Iappointment\Repositories\AppointmentFieldRepository')->find($id);
    });
    $router->get('appointmentfields', [
        'as' => 'admin.iappointment.appointmentfield.index',
        'uses' => 'AppointmentFieldController@index',
        'middleware' => 'can:iappointment.appointmentfields.index',
    ]);
    $router->get('appointmentfields/create', [
        'as' => 'admin.iappointment.appointmentfield.create',
        'uses' => 'AppointmentFieldController@create',
        'middleware' => 'can:iappointment.appointmentfields.create',
    ]);
    $router->post('appointmentfields', [
        'as' => 'admin.iappointment.appointmentfield.store',
        'uses' => 'AppointmentFieldController@store',
        'middleware' => 'can:iappointment.appointmentfields.create',
    ]);
    $router->get('appointmentfields/{appointmentfield}/edit', [
        'as' => 'admin.iappointment.appointmentfield.edit',
        'uses' => 'AppointmentFieldController@edit',
        'middleware' => 'can:iappointment.appointmentfields.edit',
    ]);
    $router->put('appointmentfields/{appointmentfield}', [
        'as' => 'admin.iappointment.appointmentfield.update',
        'uses' => 'AppointmentFieldController@update',
        'middleware' => 'can:iappointment.appointmentfields.edit',
    ]);
    $router->delete('appointmentfields/{appointmentfield}', [
        'as' => 'admin.iappointment.appointmentfield.destroy',
        'uses' => 'AppointmentFieldController@destroy',
        'middleware' => 'can:iappointment.appointmentfields.destroy',
    ]);
    $router->bind('appointmentstatus', function ($id) {
        return app('Modules\Iappointment\Repositories\AppointmentStatusRepository')->find($id);
    });
    $router->get('appointmentstatuses', [
        'as' => 'admin.iappointment.appointmentstatus.index',
        'uses' => 'AppointmentStatusController@index',
        'middleware' => 'can:iappointment.appointmentstatuses.index',
    ]);
    $router->get('appointmentstatuses/create', [
        'as' => 'admin.iappointment.appointmentstatus.create',
        'uses' => 'AppointmentStatusController@create',
        'middleware' => 'can:iappointment.appointmentstatuses.create',
    ]);
    $router->post('appointmentstatuses', [
        'as' => 'admin.iappointment.appointmentstatus.store',
        'uses' => 'AppointmentStatusController@store',
        'middleware' => 'can:iappointment.appointmentstatuses.create',
    ]);
    $router->get('appointmentstatuses/{appointmentstatus}/edit', [
        'as' => 'admin.iappointment.appointmentstatus.edit',
        'uses' => 'AppointmentStatusController@edit',
        'middleware' => 'can:iappointment.appointmentstatuses.edit',
    ]);
    $router->put('appointmentstatuses/{appointmentstatus}', [
        'as' => 'admin.iappointment.appointmentstatus.update',
        'uses' => 'AppointmentStatusController@update',
        'middleware' => 'can:iappointment.appointmentstatuses.edit',
    ]);
    $router->delete('appointmentstatuses/{appointmentstatus}', [
        'as' => 'admin.iappointment.appointmentstatus.destroy',
        'uses' => 'AppointmentStatusController@destroy',
        'middleware' => 'can:iappointment.appointmentstatuses.destroy',
    ]);
    $router->bind('categoryform', function ($id) {
        return app('Modules\Iappointment\Repositories\CategoryFormRepository')->find($id);
    });
    $router->get('categoryforms', [
        'as' => 'admin.iappointment.categoryform.index',
        'uses' => 'CategoryFormController@index',
        'middleware' => 'can:iappointment.categoryforms.index',
    ]);
    $router->get('categoryforms/create', [
        'as' => 'admin.iappointment.categoryform.create',
        'uses' => 'CategoryFormController@create',
        'middleware' => 'can:iappointment.categoryforms.create',
    ]);
    $router->post('categoryforms', [
        'as' => 'admin.iappointment.categoryform.store',
        'uses' => 'CategoryFormController@store',
        'middleware' => 'can:iappointment.categoryforms.create',
    ]);
    $router->get('categoryforms/{categoryform}/edit', [
        'as' => 'admin.iappointment.categoryform.edit',
        'uses' => 'CategoryFormController@edit',
        'middleware' => 'can:iappointment.categoryforms.edit',
    ]);
    $router->put('categoryforms/{categoryform}', [
        'as' => 'admin.iappointment.categoryform.update',
        'uses' => 'CategoryFormController@update',
        'middleware' => 'can:iappointment.categoryforms.edit',
    ]);
    $router->delete('categoryforms/{categoryform}', [
        'as' => 'admin.iappointment.categoryform.destroy',
        'uses' => 'CategoryFormController@destroy',
        'middleware' => 'can:iappointment.categoryforms.destroy',
    ]);
    $router->bind('provider', function ($id) {
        return app('Modules\Iappointment\Repositories\ProviderRepository')->find($id);
    });
    $router->get('providers', [
        'as' => 'admin.iappointment.provider.index',
        'uses' => 'ProviderController@index',
        'middleware' => 'can:iappointment.providers.index',
    ]);
    $router->get('providers/create', [
        'as' => 'admin.iappointment.provider.create',
        'uses' => 'ProviderController@create',
        'middleware' => 'can:iappointment.providers.create',
    ]);
    $router->post('providers', [
        'as' => 'admin.iappointment.provider.store',
        'uses' => 'ProviderController@store',
        'middleware' => 'can:iappointment.providers.create',
    ]);
    $router->get('providers/{provider}/edit', [
        'as' => 'admin.iappointment.provider.edit',
        'uses' => 'ProviderController@edit',
        'middleware' => 'can:iappointment.providers.edit',
    ]);
    $router->put('providers/{provider}', [
        'as' => 'admin.iappointment.provider.update',
        'uses' => 'ProviderController@update',
        'middleware' => 'can:iappointment.providers.edit',
    ]);
    $router->delete('providers/{provider}', [
        'as' => 'admin.iappointment.provider.destroy',
        'uses' => 'ProviderController@destroy',
        'middleware' => 'can:iappointment.providers.destroy',
    ]);
    // append
});
