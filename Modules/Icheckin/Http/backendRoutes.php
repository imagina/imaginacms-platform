<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/icheckin'], function (Router $router) {
    $router->bind('job', function ($id) {
        return app('Modules\Icheckin\Repositories\JobRepository')->find($id);
    });
    $router->get('jobs', [
        'as' => 'admin.icheckin.job.index',
        'uses' => 'JobController@index',
        'middleware' => 'can:icheckin.jobs.index'
    ]);
    $router->get('jobs/create', [
        'as' => 'admin.icheckin.job.create',
        'uses' => 'JobController@create',
        'middleware' => 'can:icheckin.jobs.create'
    ]);
    $router->post('jobs', [
        'as' => 'admin.icheckin.job.store',
        'uses' => 'JobController@store',
        'middleware' => 'can:icheckin.jobs.create'
    ]);
    $router->get('jobs/{job}/edit', [
        'as' => 'admin.icheckin.job.edit',
        'uses' => 'JobController@edit',
        'middleware' => 'can:icheckin.jobs.edit'
    ]);
    $router->put('jobs/{job}', [
        'as' => 'admin.icheckin.job.update',
        'uses' => 'JobController@update',
        'middleware' => 'can:icheckin.jobs.edit'
    ]);
    $router->delete('jobs/{job}', [
        'as' => 'admin.icheckin.job.destroy',
        'uses' => 'JobController@destroy',
        'middleware' => 'can:icheckin.jobs.destroy'
    ]);
    $router->bind('request', function ($id) {
        return app('Modules\Icheckin\Repositories\RequestRepository')->find($id);
    });
    $router->get('requests', [
        'as' => 'admin.icheckin.request.index',
        'uses' => 'RequestController@index',
        'middleware' => 'can:icheckin.requests.index'
    ]);
    $router->get('requests/create', [
        'as' => 'admin.icheckin.request.create',
        'uses' => 'RequestController@create',
        'middleware' => 'can:icheckin.requests.create'
    ]);
    $router->post('requests', [
        'as' => 'admin.icheckin.request.store',
        'uses' => 'RequestController@store',
        'middleware' => 'can:icheckin.requests.create'
    ]);
    $router->get('requests/{request}/edit', [
        'as' => 'admin.icheckin.request.edit',
        'uses' => 'RequestController@edit',
        'middleware' => 'can:icheckin.requests.edit'
    ]);
    $router->put('requests/{request}', [
        'as' => 'admin.icheckin.request.update',
        'uses' => 'RequestController@update',
        'middleware' => 'can:icheckin.requests.edit'
    ]);
    $router->delete('requests/{request}', [
        'as' => 'admin.icheckin.request.destroy',
        'uses' => 'RequestController@destroy',
        'middleware' => 'can:icheckin.requests.destroy'
    ]);
    $router->bind('shift', function ($id) {
        return app('Modules\Icheckin\Repositories\ShiftRepository')->find($id);
    });
    $router->get('shifts', [
        'as' => 'admin.icheckin.shift.index',
        'uses' => 'ShiftController@index',
        'middleware' => 'can:icheckin.shifts.index'
    ]);
    $router->get('shifts/create', [
        'as' => 'admin.icheckin.shift.create',
        'uses' => 'ShiftController@create',
        'middleware' => 'can:icheckin.shifts.create'
    ]);
    $router->post('shifts', [
        'as' => 'admin.icheckin.shift.store',
        'uses' => 'ShiftController@store',
        'middleware' => 'can:icheckin.shifts.create'
    ]);
    $router->get('shifts/{shift}/edit', [
        'as' => 'admin.icheckin.shift.edit',
        'uses' => 'ShiftController@edit',
        'middleware' => 'can:icheckin.shifts.edit'
    ]);
    $router->put('shifts/{shift}', [
        'as' => 'admin.icheckin.shift.update',
        'uses' => 'ShiftController@update',
        'middleware' => 'can:icheckin.shifts.edit'
    ]);
    $router->delete('shifts/{shift}', [
        'as' => 'admin.icheckin.shift.destroy',
        'uses' => 'ShiftController@destroy',
        'middleware' => 'can:icheckin.shifts.destroy'
    ]);
 
    $router->bind('approval', function ($id) {
        return app('Modules\Icheckin\Repositories\ApprovalRepository')->find($id);
    });
    $router->get('approvals', [
        'as' => 'admin.icheckin.approval.index',
        'uses' => 'ApprovalController@index',
        'middleware' => 'can:icheckin.approvals.index'
    ]);
    $router->get('approvals/create', [
        'as' => 'admin.icheckin.approval.create',
        'uses' => 'ApprovalController@create',
        'middleware' => 'can:icheckin.approvals.create'
    ]);
    $router->post('approvals', [
        'as' => 'admin.icheckin.approval.store',
        'uses' => 'ApprovalController@store',
        'middleware' => 'can:icheckin.approvals.create'
    ]);
    $router->get('approvals/{approval}/edit', [
        'as' => 'admin.icheckin.approval.edit',
        'uses' => 'ApprovalController@edit',
        'middleware' => 'can:icheckin.approvals.edit'
    ]);
    $router->put('approvals/{approval}', [
        'as' => 'admin.icheckin.approval.update',
        'uses' => 'ApprovalController@update',
        'middleware' => 'can:icheckin.approvals.edit'
    ]);
    $router->delete('approvals/{approval}', [
        'as' => 'admin.icheckin.approval.destroy',
        'uses' => 'ApprovalController@destroy',
        'middleware' => 'can:icheckin.approvals.destroy'
    ]);
// append




});
