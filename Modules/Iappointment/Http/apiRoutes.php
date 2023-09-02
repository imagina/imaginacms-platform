<?php

use Illuminate\Routing\Router;

Route::prefix('/iappointment/v1')->group(function (Router $router) {
    //======  CATEGORIES
    require 'ApiRoutes/categoryRoutes.php';

    require 'ApiRoutes/appointmentRoutes.php';

    require 'ApiRoutes/appointmentLeadRoutes.php';

    require 'ApiRoutes/appointmentStatusRoutes.php';

    require 'ApiRoutes/providerRoutes.php';
});
