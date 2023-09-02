<?php

use Illuminate\Routing\Router;

/** @var Router $router */
Route::prefix('iredirect/v1')->group(function (Router $router) {
    //======  PAGES
    require 'ApiRoutes/redirectRoutes.php';
});
