<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/iprofile'], function (Router $router) {
    $router->bind('field', function ($id) {
        return app('Modules\iprofile\Repositories\FieldRepository')->find($id);
    });
    $router->get('fields', [
        'as' => 'admin.iprofile.field.index',
        'uses' => 'CustomFieldController@index',
        'middleware' => 'can:iprofile.fields.index'
    ]);
    $router->get('fields/create', [
        'as' => 'admin.iprofile.field.create',
        'uses' => 'CustomFieldController@create',
        'middleware' => 'can:iprofile.fields.create'
    ]);
    $router->post('fields', [
        'as' => 'admin.iprofile.field.store',
        'uses' => 'CustomFieldController@store',
        'middleware' => 'can:iprofile.fields.create'
    ]);
    $router->get('fields/{field}/edit', [
        'as' => 'admin.iprofile.field.edit',
        'uses' => 'CustomFieldController@edit',
        'middleware' => 'can:iprofile.fields.edit'
    ]);
    $router->put('fields/{field}', [
        'as' => 'admin.iprofile.field.update',
        'uses' => 'CustomFieldController@update',
        'middleware' => 'can:iprofile.fields.edit'
    ]);
    $router->delete('fields/{field}', [
        'as' => 'admin.iprofile.field.destroy',
        'uses' => 'CustomFieldController@destroy',
        'middleware' => 'can:iprofile.fields.destroy'
    ]);
    $router->bind('address', function ($id) {
        return app('Modules\iprofile\Repositories\AddressRepository')->find($id);
    });
    $router->get('addresses', [
        'as' => 'admin.iprofile.address.index',
        'uses' => 'AddressController@index',
        'middleware' => 'can:iprofile.addresses.index'
    ]);
    $router->get('addresses/create', [
        'as' => 'admin.iprofile.address.create',
        'uses' => 'AddressController@create',
        'middleware' => 'can:iprofile.addresses.create'
    ]);
    $router->post('addresses', [
        'as' => 'admin.iprofile.address.store',
        'uses' => 'AddressController@store',
        'middleware' => 'can:iprofile.addresses.create'
    ]);
    $router->get('addresses/{address}/edit', [
        'as' => 'admin.iprofile.address.edit',
        'uses' => 'AddressController@edit',
        'middleware' => 'can:iprofile.addresses.edit'
    ]);
    $router->put('addresses/{address}', [
        'as' => 'admin.iprofile.address.update',
        'uses' => 'AddressController@update',
        'middleware' => 'can:iprofile.addresses.edit'
    ]);
    $router->delete('addresses/{address}', [
        'as' => 'admin.iprofile.address.destroy',
        'uses' => 'AddressController@destroy',
        'middleware' => 'can:iprofile.addresses.destroy'
    ]);
    $router->bind('department', function ($id) {
        return app('Modules\iprofile\Repositories\DepartmentRepository')->find($id);
    });
    $router->get('departments', [
        'as' => 'admin.iprofile.department.index',
        'uses' => 'DepartmentController@index',
        'middleware' => 'can:iprofile.departments.index'
    ]);
    $router->get('departments/create', [
        'as' => 'admin.iprofile.department.create',
        'uses' => 'DepartmentController@create',
        'middleware' => 'can:iprofile.departments.create'
    ]);
    $router->post('departments', [
        'as' => 'admin.iprofile.department.store',
        'uses' => 'DepartmentController@store',
        'middleware' => 'can:iprofile.departments.create'
    ]);
    $router->get('departments/{department}/edit', [
        'as' => 'admin.iprofile.department.edit',
        'uses' => 'DepartmentController@edit',
        'middleware' => 'can:iprofile.departments.edit'
    ]);
    $router->put('departments/{department}', [
        'as' => 'admin.iprofile.department.update',
        'uses' => 'DepartmentController@update',
        'middleware' => 'can:iprofile.departments.edit'
    ]);
    $router->delete('departments/{department}', [
        'as' => 'admin.iprofile.department.destroy',
        'uses' => 'DepartmentController@destroy',
        'middleware' => 'can:iprofile.departments.destroy'
    ]);
    $router->bind('setting', function ($id) {
        return app('Modules\iprofile\Repositories\SettingRepository')->find($id);
    });
    $router->get('settings', [
        'as' => 'admin.iprofile.setting.index',
        'uses' => 'DepartmentSettingController@index',
        'middleware' => 'can:iprofile.settings.index'
    ]);
    $router->get('settings/create', [
        'as' => 'admin.iprofile.setting.create',
        'uses' => 'DepartmentSettingController@create',
        'middleware' => 'can:iprofile.settings.create'
    ]);
    $router->post('settings', [
        'as' => 'admin.iprofile.setting.store',
        'uses' => 'DepartmentSettingController@store',
        'middleware' => 'can:iprofile.settings.create'
    ]);
    $router->get('settings/{setting}/edit', [
        'as' => 'admin.iprofile.setting.edit',
        'uses' => 'DepartmentSettingController@edit',
        'middleware' => 'can:iprofile.settings.edit'
    ]);
    $router->put('settings/{setting}', [
        'as' => 'admin.iprofile.setting.update',
        'uses' => 'DepartmentSettingController@update',
        'middleware' => 'can:iprofile.settings.edit'
    ]);
    $router->delete('settings/{setting}', [
        'as' => 'admin.iprofile.setting.destroy',
        'uses' => 'DepartmentSettingController@destroy',
        'middleware' => 'can:iprofile.settings.destroy'
    ]);
    $router->bind('userdepartment', function ($id) {
        return app('Modules\iprofile\Repositories\UserDepartmentRepository')->find($id);
    });
    $router->get('userdepartments', [
        'as' => 'admin.iprofile.userdepartment.index',
        'uses' => 'UserDepartmentController@index',
        'middleware' => 'can:iprofile.userdepartments.index'
    ]);
    $router->get('userdepartments/create', [
        'as' => 'admin.iprofile.userdepartment.create',
        'uses' => 'UserDepartmentController@create',
        'middleware' => 'can:iprofile.userdepartments.create'
    ]);
    $router->post('userdepartments', [
        'as' => 'admin.iprofile.userdepartment.store',
        'uses' => 'UserDepartmentController@store',
        'middleware' => 'can:iprofile.userdepartments.create'
    ]);
    $router->get('userdepartments/{userdepartment}/edit', [
        'as' => 'admin.iprofile.userdepartment.edit',
        'uses' => 'UserDepartmentController@edit',
        'middleware' => 'can:iprofile.userdepartments.edit'
    ]);
    $router->put('userdepartments/{userdepartment}', [
        'as' => 'admin.iprofile.userdepartment.update',
        'uses' => 'UserDepartmentController@update',
        'middleware' => 'can:iprofile.userdepartments.edit'
    ]);
    $router->delete('userdepartments/{userdepartment}', [
        'as' => 'admin.iprofile.userdepartment.destroy',
        'uses' => 'UserDepartmentController@destroy',
        'middleware' => 'can:iprofile.userdepartments.destroy'
    ]);
    $router->bind('roleapi', function ($id) {
        return app('Modules\iprofile\Repositories\RoleApiRepository')->find($id);
    });
    $router->get('roleapis', [
        'as' => 'admin.iprofile.roleapi.index',
        'uses' => 'RoleApiController@index',
        'middleware' => 'can:iprofile.roleapis.index'
    ]);
    $router->get('roleapis/create', [
        'as' => 'admin.iprofile.roleapi.create',
        'uses' => 'RoleApiController@create',
        'middleware' => 'can:iprofile.roleapis.create'
    ]);
    $router->post('roleapis', [
        'as' => 'admin.iprofile.roleapi.store',
        'uses' => 'RoleApiController@store',
        'middleware' => 'can:iprofile.roleapis.create'
    ]);
    $router->get('roleapis/{roleapi}/edit', [
        'as' => 'admin.iprofile.roleapi.edit',
        'uses' => 'RoleApiController@edit',
        'middleware' => 'can:iprofile.roleapis.edit'
    ]);
    $router->put('roleapis/{roleapi}', [
        'as' => 'admin.iprofile.roleapi.update',
        'uses' => 'RoleApiController@update',
        'middleware' => 'can:iprofile.roleapis.edit'
    ]);
    $router->delete('roleapis/{roleapi}', [
        'as' => 'admin.iprofile.roleapi.destroy',
        'uses' => 'RoleApiController@destroy',
        'middleware' => 'can:iprofile.roleapis.destroy'
    ]);
    $router->bind('userapi', function ($id) {
        return app('Modules\iprofile\Repositories\UserApiRepository')->find($id);
    });
    $router->get('userapis', [
        'as' => 'admin.iprofile.userapi.index',
        'uses' => 'UserApiController@index',
        'middleware' => 'can:iprofile.userapis.index'
    ]);
    $router->get('userapis/create', [
        'as' => 'admin.iprofile.userapi.create',
        'uses' => 'UserApiController@create',
        'middleware' => 'can:iprofile.userapis.create'
    ]);
    $router->post('userapis', [
        'as' => 'admin.iprofile.userapi.store',
        'uses' => 'UserApiController@store',
        'middleware' => 'can:iprofile.userapis.create'
    ]);
    $router->get('userapis/{userapi}/edit', [
        'as' => 'admin.iprofile.userapi.edit',
        'uses' => 'UserApiController@edit',
        'middleware' => 'can:iprofile.userapis.edit'
    ]);
    $router->put('userapis/{userapi}', [
        'as' => 'admin.iprofile.userapi.update',
        'uses' => 'UserApiController@update',
        'middleware' => 'can:iprofile.userapis.edit'
    ]);
    $router->delete('userapis/{userapi}', [
        'as' => 'admin.iprofile.userapi.destroy',
        'uses' => 'UserApiController@destroy',
        'middleware' => 'can:iprofile.userapis.destroy'
    ]);
// append








});
