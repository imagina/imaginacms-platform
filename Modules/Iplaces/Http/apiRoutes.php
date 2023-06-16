<?php

use Illuminate\Routing\Router;

Route::prefix('iplaces/v1')->group(function (Router $router) {
    //======  PLACES
    require 'ApiRoutes/placesRoutes.php';

    //======  CATEGORIES
    require 'ApiRoutes/categoriesRoutes.php';

    //======  SCHEDULES
    require 'ApiRoutes/schedulesRoutes.php';

    //======  SERVICES
    require 'ApiRoutes/servicesRoutes.php';

    //======  SPACES
    require 'ApiRoutes/spacesRoutes.php';

    //======  ZONES
    require 'ApiRoutes/zonesRoutes.php';
});
