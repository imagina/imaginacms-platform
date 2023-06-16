<?php

use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('ipay')->group(function (Router $router) {
    $router->get('all', [
        'as' => 'ipay.all',
        'uses' => 'PublicController@getAll',
    ]);
});

Route::get('ipay/respuesta', [PublicController::class, 'respuesta']);
