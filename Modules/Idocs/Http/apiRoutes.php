<?php

use Illuminate\Routing\Router;

Route::prefix('idocs/v1')->group(function (Router $router) {
    //======  CATEGORIES
    require 'ApiRoutes/categoryRoutes.php';

    //======  Docs
    require 'ApiRoutes/documentRoutes.php';
});
