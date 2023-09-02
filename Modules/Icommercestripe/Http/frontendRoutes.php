<?php

use Illuminate\Routing\Router;

Route::prefix('icommercestripe')->group(function (Router $router) {
    $router->get('/{eUrl}', [
        'as' => 'icommercestripe',
        'uses' => 'PublicController@index',
    ]);

    $router->get('connect/refresh/url', [
        'as' => 'icommercestripe.connect.refresh.url',
        'uses' => 'PublicController@connectRefreshUrl',
        //'middleware' => ['auth']
    ]);
});
