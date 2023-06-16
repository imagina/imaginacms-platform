<?php

use Illuminate\Routing\Router;

/*Routes API*/
Route::prefix('/menu')->group(function (Router $router) {
    $router->get('/{id}', [
        'as' => 'api.menu.show',
        'uses' => 'MenuApiController@show',
    ]);
});
