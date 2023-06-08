<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => 'ipay'], function (Router $router) {

    $router->get('all', [
        'as' => 'ipay.all',
        'uses' => 'PublicController@getAll'
    ]);

});

Route::get('ipay/respuesta', 'PublicController@respuesta');
