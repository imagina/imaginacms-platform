<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::group(['prefix' => '/icommerceagree'], function (Router $router) {
    $router->bind('icommerceagree', function ($id) {
        return app('Modules\Icommerceagree\Repositories\IcommerceAgreeRepository')->find($id);
    });
    $router->get('icommerceagrees', [
        'as' => 'admin.icommerceagree.icommerceagree.index',
        'uses' => 'IcommerceAgreeController@index',
        'middleware' => 'can:icommerceagree.icommerceagrees.index',
    ]);
    $router->get('icommerceagrees/create', [
        'as' => 'admin.icommerceagree.icommerceagree.create',
        'uses' => 'IcommerceAgreeController@create',
        'middleware' => 'can:icommerceagree.icommerceagrees.create',
    ]);
    $router->post('icommerceagrees', [
        'as' => 'admin.icommerceagree.icommerceagree.store',
        'uses' => 'IcommerceAgreeController@store',
        'middleware' => 'can:icommerceagree.icommerceagrees.create',
    ]);
    $router->get('icommerceagrees/{icommerceagree}/edit', [
        'as' => 'admin.icommerceagree.icommerceagree.edit',
        'uses' => 'IcommerceAgreeController@edit',
        'middleware' => 'can:icommerceagree.icommerceagrees.edit',
    ]);
    $router->put('icommerceagrees/{icommerceagree}', [
        'as' => 'admin.icommerceagree.icommerceagree.update',
        'uses' => 'IcommerceAgreeController@update',
        'middleware' => 'can:icommerceagree.icommerceagrees.edit',
    ]);
    $router->delete('icommerceagrees/{icommerceagree}', [
        'as' => 'admin.icommerceagree.icommerceagree.destroy',
        'uses' => 'IcommerceAgreeController@destroy',
        'middleware' => 'can:icommerceagree.icommerceagrees.destroy',
    ]);
    // append
});
