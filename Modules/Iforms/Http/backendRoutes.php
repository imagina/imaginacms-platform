<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/iforms'], function (Router $router) {
    $router->bind('form', function ($id) {
        return app('Modules\Iforms\Repositories\FormRepository')->find($id);
    });
    $router->get('forms', [
        'as' => 'admin.iforms.form.index',
        'uses' => 'FormController@index',
        'middleware' => 'can:iforms.forms.index'
    ]);
    $router->get('forms/create', [
        'as' => 'admin.iforms.form.create',
        'uses' => 'FormController@create',
        'middleware' => 'can:iforms.forms.create'
    ]);
    $router->post('forms', [
        'as' => 'admin.iforms.form.store',
        'uses' => 'FormController@store',
        'middleware' => 'can:iforms.forms.create'
    ]);
    $router->get('forms/{form}/edit', [
        'as' => 'admin.iforms.form.edit',
        'uses' => 'FormController@edit',
        'middleware' => 'can:iforms.forms.edit'
    ]);
    $router->put('forms/{form}', [
        'as' => 'admin.iforms.form.update',
        'uses' => 'FormController@update',
        'middleware' => 'can:iforms.forms.edit'
    ]);
    $router->delete('forms/{form}', [
        'as' => 'admin.iforms.form.destroy',
        'uses' => 'FormController@destroy',
        'middleware' => 'can:iforms.forms.destroy'
    ]);
    $router->bind('field', function ($id) {
        return app('Modules\Iforms\Repositories\FieldRepository')->find($id);
    });
    $router->get('fields', [
        'as' => 'admin.iforms.field.index',
        'uses' => 'FieldController@index',
        'middleware' => 'can:iforms.fields.index'
    ]);
    $router->get('fields/create', [
        'as' => 'admin.iforms.field.create',
        'uses' => 'FieldController@create',
        'middleware' => 'can:iforms.fields.create'
    ]);
    $router->post('fields', [
        'as' => 'admin.iforms.field.store',
        'uses' => 'FieldController@store',
        'middleware' => 'can:iforms.fields.create'
    ]);
    $router->get('fields/{field}/edit', [
        'as' => 'admin.iforms.field.edit',
        'uses' => 'FieldController@edit',
        'middleware' => 'can:iforms.fields.edit'
    ]);
    $router->put('fields/{field}', [
        'as' => 'admin.iforms.field.update',
        'uses' => 'FieldController@update',
        'middleware' => 'can:iforms.fields.edit'
    ]);
    $router->delete('fields/{field}', [
        'as' => 'admin.iforms.field.destroy',
        'uses' => 'FieldController@destroy',
        'middleware' => 'can:iforms.fields.destroy'
    ]);
    $router->bind('lead', function ($id) {
        return app('Modules\Iforms\Repositories\LeadRepository')->find($id);
    });
    $router->get('leads', [
        'as' => 'admin.iforms.lead.index',
        'uses' => 'LeadController@index',
        'middleware' => 'can:iforms.leads.index'
    ]);
    $router->get('leads/create', [
        'as' => 'admin.iforms.lead.create',
        'uses' => 'LeadController@create',
        'middleware' => 'can:iforms.leads.create'
    ]);
    $router->post('leads', [
        'as' => 'admin.iforms.lead.store',
        'uses' => 'LeadController@store',
        'middleware' => 'can:iforms.leads.create'
    ]);
    $router->get('leads/{lead}/edit', [
        'as' => 'admin.iforms.lead.edit',
        'uses' => 'LeadController@edit',
        'middleware' => 'can:iforms.leads.edit'
    ]);
    $router->put('leads/{lead}', [
        'as' => 'admin.iforms.lead.update',
        'uses' => 'LeadController@update',
        'middleware' => 'can:iforms.leads.edit'
    ]);
    $router->delete('leads/{lead}', [
        'as' => 'admin.iforms.lead.destroy',
        'uses' => 'LeadController@destroy',
        'middleware' => 'can:iforms.leads.destroy'
    ]);
// append



});
