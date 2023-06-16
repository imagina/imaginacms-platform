<?php

use Illuminate\Routing\Router;

/*Routes API*/
Route::group(['prefix' => '/menu'], function (Router $router) {
    $router->get('/{id}', [
        'as' => 'api.menu.show',
        'uses' => 'MenuApiController@show',
    ]);
});
