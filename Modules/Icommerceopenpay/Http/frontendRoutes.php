<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'icommerceopenpay'], function (Router $router) {
    $router->get('/{eUrl}', [
        'as' => 'icommerceopenpay',
        'uses' => 'PublicController@index',
    ]);
});
