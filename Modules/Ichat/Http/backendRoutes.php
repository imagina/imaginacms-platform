<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/ichat'], function (Router $router) {
    $router->bind('message', function ($id) {
        return app('Modules\Ichat\Repositories\MessageRepository')->find($id);
    });
    $router->get('messages', [
        'as' => 'admin.ichat.message.index',
        'uses' => 'MessageController@index',
        'middleware' => 'can:ichat.messages.index'
    ]);
    $router->get('messages/create', [
        'as' => 'admin.ichat.message.create',
        'uses' => 'MessageController@create',
        'middleware' => 'can:ichat.messages.create'
    ]);
    $router->post('messages', [
        'as' => 'admin.ichat.message.store',
        'uses' => 'MessageController@store',
        'middleware' => 'can:ichat.messages.create'
    ]);
    $router->get('messages/{message}/edit', [
        'as' => 'admin.ichat.message.edit',
        'uses' => 'MessageController@edit',
        'middleware' => 'can:ichat.messages.edit'
    ]);
    $router->put('messages/{message}', [
        'as' => 'admin.ichat.message.update',
        'uses' => 'MessageController@update',
        'middleware' => 'can:ichat.messages.edit'
    ]);
    $router->delete('messages/{message}', [
        'as' => 'admin.ichat.message.destroy',
        'uses' => 'MessageController@destroy',
        'middleware' => 'can:ichat.messages.destroy'
    ]);
// append

});
