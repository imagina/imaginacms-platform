<?php

use Illuminate\Routing\Router;

Route::prefix('iblog/v1')->group(function (Router $router) {
    //======  CATEGORIES
    require 'ApiRoutes/categoryRoutes.php';

    //======  POSTS
    require 'ApiRoutes/postRoutes.php';

    //append
});
