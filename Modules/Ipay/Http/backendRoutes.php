<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('ipay')->group(function (Router $router) {
    Route::prefix('pay')->group(function (Router $router) {
        $router->bind('config', function ($id) {
            return app('Modules\Ipay\Repositories\ConfigRepository')->find($id);
        });
        $router->get('/', [
            'as' => 'admin.ipay.config.index',
            'uses' => 'ConfigController@index',
            'middleware' => 'can:ipay.config.index',
        ]);

        $router->put('/', [
            'as' => 'admin.ipay.config.update',
            'uses' => 'ConfigController@update',
            'middleware' => 'can:ipay.config.edit',
        ]);
        // append
    });
});
