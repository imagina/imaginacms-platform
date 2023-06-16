<?php

use Illuminate\Routing\Router;

Route::prefix('/icommercepricelist/v3')->middleware('auth:api')->group(function (Router $router) {
    //======  PRICE LISTS
    require 'ApiRoutes/priceListRoutes.php';

    //======  PRODUCT LISTS
    require 'ApiRoutes/productListRoutes.php';
});
