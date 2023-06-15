<?php

use Illuminate\Routing\Router;
/** @var Router $router */

Route::group(['prefix' =>'/idocs'], function (Router $router) {
    $router->bind('idocCategory', function ($id) {
        return app('Modules\Idocs\Repositories\CategoryRepository')->find($id);
    });
    $router->get('categories', [
        'as' => 'admin.idocs.category.index',
        'uses' => 'CategoryController@index',
        'middleware' => 'can:idocs.categories.index'
    ]);
    $router->get('categories/create', [
        'as' => 'admin.idocs.category.create',
        'uses' => 'CategoryController@create',
        'middleware' => 'can:idocs.categories.create'
    ]);
    $router->post('categories', [
        'as' => 'admin.idocs.category.store',
        'uses' => 'CategoryController@store',
        'middleware' => 'can:idocs.categories.create'
    ]);
    $router->get('categories/{idocCategory}/edit', [
        'as' => 'admin.idocs.category.edit',
        'uses' => 'CategoryController@edit',
        'middleware' => 'can:idocs.categories.edit'
    ]);
    $router->put('categories/{idocCategory}', [
        'as' => 'admin.idocs.category.update',
        'uses' => 'CategoryController@update',
        'middleware' => 'can:idocs.categories.edit'
    ]);
    $router->delete('categories/{idocCategory}', [
        'as' => 'admin.idocs.category.destroy',
        'uses' => 'CategoryController@destroy',
        'middleware' => 'can:idocs.categories.destroy'
    ]);
    $router->bind('document', function ($id) {
        return app('Modules\Idocs\Repositories\DocumentRepository')->find($id);
    });
    $router->get('documents', [
        'as' => 'admin.idocs.document.index',
        'uses' => 'DocumentController@index',
        'middleware' => 'can:idocs.documents.index'
    ]);
    $router->get('documents/create', [
        'as' => 'admin.idocs.document.create',
        'uses' => 'DocumentController@create',
        'middleware' => 'can:idocs.documents.create'
    ]);
    $router->post('documents', [
        'as' => 'admin.idocs.document.store',
        'uses' => 'DocumentController@store',
        'middleware' => 'can:idocs.documents.create'
    ]);
    $router->get('documents/{document}/edit', [
        'as' => 'admin.idocs.document.edit',
        'uses' => 'DocumentController@edit',
        'middleware' => 'can:idocs.documents.edit'
    ]);
    $router->put('documents/{document}', [
        'as' => 'admin.idocs.document.update',
        'uses' => 'DocumentController@update',
        'middleware' => 'can:idocs.documents.edit'
    ]);
    $router->delete('documents/{document}', [
        'as' => 'admin.idocs.document.destroy',
        'uses' => 'DocumentController@destroy',
        'middleware' => 'can:idocs.documents.destroy'
    ]);

    $router->get('documents/migrate', [
        'as' => 'admin.idocs.document.migrate',
        'uses' => 'DocumentController@migration',
        'middleware' => 'can:idocs.documents.migrate'
    ]);
// append
    $router->post('documents/import', [
        'as' => 'admin.idocs.document.import',
        'uses' => 'DocumentController@import',
        'middleware' => 'can:idocs.documents.migrate'
    ]);

});
