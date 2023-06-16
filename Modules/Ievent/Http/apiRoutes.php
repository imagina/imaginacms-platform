<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => '/ievent/v1'], function (Router $router) {
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
