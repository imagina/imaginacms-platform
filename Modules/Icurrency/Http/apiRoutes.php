<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/icurrency/v1'], function (Router $router) {

  /*currencies*/
  require ('ApiRoutes/currencyRoutes.php');

});
