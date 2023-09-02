<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('/icommercecredibanco')->group(function (Router $router) {
    $router->bind('icommercecredibanco', function ($id) {
        return app('Modules\Icommercecredibanco\Repositories\IcommerceCredibancoRepository')->find($id);
    });
    $router->get('icommercecredibancos', [
        'as' => 'admin.icommercecredibanco.icommercecredibanco.index',
        'uses' => 'IcommerceCredibancoController@index',
        'middleware' => 'can:icommercecredibanco.icommercecredibancos.index',
    ]);
    $router->get('icommercecredibancos/create', [
        'as' => 'admin.icommercecredibanco.icommercecredibanco.create',
        'uses' => 'IcommerceCredibancoController@create',
        'middleware' => 'can:icommercecredibanco.icommercecredibancos.create',
    ]);
    $router->post('icommercecredibancos', [
        'as' => 'admin.icommercecredibanco.icommercecredibanco.store',
        'uses' => 'IcommerceCredibancoController@store',
        'middleware' => 'can:icommercecredibanco.icommercecredibancos.create',
    ]);
    $router->get('icommercecredibancos/{icommercecredibanco}/edit', [
        'as' => 'admin.icommercecredibanco.icommercecredibanco.edit',
        'uses' => 'IcommerceCredibancoController@edit',
        'middleware' => 'can:icommercecredibanco.icommercecredibancos.edit',
    ]);
    $router->put('icommercecredibancos/{icommercecredibanco}', [
        'as' => 'admin.icommercecredibanco.icommercecredibanco.update',
        'uses' => 'IcommerceCredibancoController@update',
        'middleware' => 'can:icommercecredibanco.icommercecredibancos.edit',
    ]);
    $router->delete('icommercecredibancos/{icommercecredibanco}', [
        'as' => 'admin.icommercecredibanco.icommercecredibanco.destroy',
        'uses' => 'IcommerceCredibancoController@destroy',
        'middleware' => 'can:icommercecredibanco.icommercecredibancos.destroy',
    ]);
    $router->bind('transaction', function ($id) {
        return app('Modules\Icommercecredibanco\Repositories\TransactionRepository')->find($id);
    });
    $router->get('transactions', [
        'as' => 'admin.icommercecredibanco.transaction.index',
        'uses' => 'TransactionController@index',
        'middleware' => 'can:icommercecredibanco.transactions.index',
    ]);
    $router->get('transactions/create', [
        'as' => 'admin.icommercecredibanco.transaction.create',
        'uses' => 'TransactionController@create',
        'middleware' => 'can:icommercecredibanco.transactions.create',
    ]);
    $router->post('transactions', [
        'as' => 'admin.icommercecredibanco.transaction.store',
        'uses' => 'TransactionController@store',
        'middleware' => 'can:icommercecredibanco.transactions.create',
    ]);
    $router->get('transactions/{transaction}/edit', [
        'as' => 'admin.icommercecredibanco.transaction.edit',
        'uses' => 'TransactionController@edit',
        'middleware' => 'can:icommercecredibanco.transactions.edit',
    ]);
    $router->put('transactions/{transaction}', [
        'as' => 'admin.icommercecredibanco.transaction.update',
        'uses' => 'TransactionController@update',
        'middleware' => 'can:icommercecredibanco.transactions.edit',
    ]);
    $router->delete('transactions/{transaction}', [
        'as' => 'admin.icommercecredibanco.transaction.destroy',
        'uses' => 'TransactionController@destroy',
        'middleware' => 'can:icommercecredibanco.transactions.destroy',
    ]);
    // append
});
