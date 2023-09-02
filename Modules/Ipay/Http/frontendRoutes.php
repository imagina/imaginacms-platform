<?php

use App\Http\Controllers\PublicController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/** @var Router $router */
Route::prefix('ipay')->group(function (Router $router) {
    $router->get('all', [
        'as' => 'ipay.all',
        'uses' => 'PublicController@getAll',
    ]);
});

Route::get('ipay/respuesta', [PublicController::class, 'respuesta']);
