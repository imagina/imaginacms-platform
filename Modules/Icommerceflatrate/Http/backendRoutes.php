<?php

use Illuminate\Routing\Router;
/** @var Router $router */

Route::group(['prefix' =>'/icommerceflatrate'], function (Router $router) {
    $router->bind('icommerceflatrate', function ($id) {
        return app('Modules\Icommerceflatrate\Repositories\IcommerceFlatrateRepository')->find($id);
    });
    $router->get('icommerceflatrates', [
        'as' => 'admin.icommerceflatrate.icommerceflatrate.index',
        'uses' => 'IcommerceFlatrateController@index',
        'middleware' => 'can:icommerceflatrate.icommerceflatrates.index'
    ]);
    $router->get('icommerceflatrates/create', [
        'as' => 'admin.icommerceflatrate.icommerceflatrate.create',
        'uses' => 'IcommerceFlatrateController@create',
        'middleware' => 'can:icommerceflatrate.icommerceflatrates.create'
    ]);
    $router->post('icommerceflatrates', [
        'as' => 'admin.icommerceflatrate.icommerceflatrate.store',
        'uses' => 'IcommerceFlatrateController@store',
        'middleware' => 'can:icommerceflatrate.icommerceflatrates.create'
    ]);
    $router->get('icommerceflatrates/{icommerceflatrate}/edit', [
        'as' => 'admin.icommerceflatrate.icommerceflatrate.edit',
        'uses' => 'IcommerceFlatrateController@edit',
        'middleware' => 'can:icommerceflatrate.icommerceflatrates.edit'
    ]);
    $router->put('icommerceflatrates/{icommerceflatrate}', [
        'as' => 'admin.icommerceflatrate.icommerceflatrate.update',
        'uses' => 'IcommerceFlatrateController@update',
        'middleware' => 'can:icommerceflatrate.icommerceflatrates.edit'
    ]);
    $router->delete('icommerceflatrates/{icommerceflatrate}', [
        'as' => 'admin.icommerceflatrate.icommerceflatrate.destroy',
        'uses' => 'IcommerceFlatrateController@destroy',
        'middleware' => 'can:icommerceflatrate.icommerceflatrates.destroy'
    ]);
// append

});
