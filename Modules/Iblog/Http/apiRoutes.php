<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'iblog/v1'], function (Router $router) {
    //======  CATEGORIES
    require 'ApiRoutes/categoryRoutes.php';

    //======  POSTS
    require 'ApiRoutes/postRoutes.php';

    //append
});
