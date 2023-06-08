<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/icheckin/v1'], function (Router $router) {
  //Shifts
  require('ApiRoutes/ShiftApiRoutes.php');
  //Jobs
  require('ApiRoutes/JobApiRoutes.php');
  //Requests
  require('ApiRoutes/RequestApiRoutes.php');
//Approvals
  require('ApiRoutes/ApprovalApiRoutes.php');

});