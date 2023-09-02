<?php

use Illuminate\Routing\Router;

Route::prefix('icommercexpay')->group(function (Router $router) {
    $locale = LaravelLocalization::setLocale() ?: App::getLocale();

    $router->get('/{eUrl}', [
        'as' => 'icommercexpay',
        'uses' => 'PublicController@index',
    ]);
});
