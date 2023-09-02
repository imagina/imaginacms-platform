<?php

use Illuminate\Routing\Router;

Route::prefix('icommerceopenpay')->group(function (Router $router) {
    $router->get('/{eUrl}', [
        'as' => 'icommerceopenpay',
        'uses' => 'PublicController@index',
    ]);
});
