<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => 'idocs/v1'], function (Router $router) {
    //======  CATEGORIES
    require 'ApiRoutes/categoryRoutes.php';

    //======  Docs
    require 'ApiRoutes/documentRoutes.php';
});
