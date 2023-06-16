<?php

use Illuminate\Routing\Router;

Route::prefix('/ievent/v1')->group(function (Router $router) {
    //======  EVENTS
    require 'ApiRoutes/eventRoutes.php';

    //======  CATEGORIES
    require 'ApiRoutes/categoryRoutes.php';

    //======  RECURRENCES
    require 'ApiRoutes/recurrenceRoutes.php';

    //======  ATTENDANTS
    require 'ApiRoutes/attendantRoutes.php';

    //======  COMMENTS
    require 'ApiRoutes/commentRoutes.php';
});
