<?php

use Illuminate\Routing\Router;

Route::prefix('/icurrency/v1')->group(function (Router $router) {
    /*currencies*/
    require 'ApiRoutes/currencyRoutes.php';
});
