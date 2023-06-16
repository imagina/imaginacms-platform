<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'icommercexpay'], function (Router $router) {
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();

    $router->get('/{eUrl}', [
        'as' => 'icommercexpay',
        'uses' => 'PublicController@index',
    ]);
});
