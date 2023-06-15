<?php

use Illuminate\Routing\Router;

Route::group(['prefix' => 'iform/v4'], function (Router $router) {

  require('ApiRoutes/formRoutes.php');

  require('ApiRoutes/fieldRoutes.php');

  require('ApiRoutes/blockRoutes.php');

  require('ApiRoutes/leadRoutes.php');

  require ('ApiRoutes/typeRoutes.php');

  require ('ApiRoutes/formTypeRoutes.php');

});

