<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('/icurrency')->group(function (Router $router) {
    $router->bind('currency', function ($id) {
        return app('Modules\Icurrency\Repositories\CurrencyRepository')->find($id);
    });
    $router->get('currencies', [
        'as' => 'admin.icurrency.currency.index',
        'uses' => 'CurrencyController@index',
        'middleware' => 'can:icurrency.currencies.index',
    ]);
    $router->get('currencies/create', [
        'as' => 'admin.icurrency.currency.create',
        'uses' => 'CurrencyController@create',
        'middleware' => 'can:icurrency.currencies.create',
    ]);
    $router->post('currencies', [
        'as' => 'admin.icurrency.currency.store',
        'uses' => 'CurrencyController@store',
        'middleware' => 'can:icurrency.currencies.create',
    ]);
    $router->get('currencies/{currency}/edit', [
        'as' => 'admin.icurrency.currency.edit',
        'uses' => 'CurrencyController@edit',
        'middleware' => 'can:icurrency.currencies.edit',
    ]);
    $router->put('currencies/{currency}', [
        'as' => 'admin.icurrency.currency.update',
        'uses' => 'CurrencyController@update',
        'middleware' => 'can:icurrency.currencies.edit',
    ]);
    $router->delete('currencies/{currency}', [
        'as' => 'admin.icurrency.currency.destroy',
        'uses' => 'CurrencyController@destroy',
        'middleware' => 'can:icurrency.currencies.destroy',
    ]);
    // append
});
