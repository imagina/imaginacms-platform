<?php

use Illuminate\Routing\Router;

Route::prefix('icommerceflatrate')->group(function (Router $router) {
    $router->get('/', [
        'as' => 'icommerceflatrate.api.flatrate.init',
        'uses' => 'IcommerceFlatrateApiController@init',
    ]);
});
