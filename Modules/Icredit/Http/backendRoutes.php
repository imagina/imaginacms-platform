<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/icredit'], function (Router $router) {
    $router->bind('credit', function ($id) {
        return app('Modules\Icredit\Repositories\CreditRepository')->find($id);
    });
    $router->get('credits', [
        'as' => 'admin.icredit.credit.index',
        'uses' => 'CreditController@index',
        'middleware' => 'can:icredit.credits.index'
    ]);
    $router->get('credits/create', [
        'as' => 'admin.icredit.credit.create',
        'uses' => 'CreditController@create',
        'middleware' => 'can:icredit.credits.create'
    ]);
    $router->post('credits', [
        'as' => 'admin.icredit.credit.store',
        'uses' => 'CreditController@store',
        'middleware' => 'can:icredit.credits.create'
    ]);
    $router->get('credits/{credit}/edit', [
        'as' => 'admin.icredit.credit.edit',
        'uses' => 'CreditController@edit',
        'middleware' => 'can:icredit.credits.edit'
    ]);
    $router->put('credits/{credit}', [
        'as' => 'admin.icredit.credit.update',
        'uses' => 'CreditController@update',
        'middleware' => 'can:icredit.credits.edit'
    ]);
    $router->delete('credits/{credit}', [
        'as' => 'admin.icredit.credit.destroy',
        'uses' => 'CreditController@destroy',
        'middleware' => 'can:icredit.credits.destroy'
    ]);
// append

});
