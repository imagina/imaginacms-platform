<?php

use Illuminate\Routing\Router;

$router->group(['prefix' => '/ibooking/v1'], function (Router $router) {
  $router->apiCrud([
    'module' => 'ibooking',
    'prefix' => 'categories',
    'controller' => 'CategoryApiController',
    'middleware' => ['index' => []] // Just Testing
  ]);
  $router->apiCrud([
    'module' => 'ibooking',
    'prefix' => 'services',
    'controller' => 'ServiceApiController',
    'middleware' => ['index' => []] // Just Testing
  ]);
  $router->apiCrud([
    'module' => 'ibooking',
    'prefix' => 'resources',
    'controller' => 'ResourceApiController',
    'middleware' => ['index' => [], 'show' => []] // Just Testing
  ]);
  $router->apiCrud([
    'module' => 'ibooking',
    'prefix' => 'reservations',
    'controller' => 'ReservationApiController',
    'middleware' => ['create' => ['optional-auth']] // Just Testing
  ]);
  $router->apiCrud([
    'module' => 'ibooking',
    'prefix' => 'reservation-items',
    'controller' => 'ReservationItemApiController',
    //'middleware' => ['create' => [],'index' => [],'delete' => []] // Just Testing
  ]);
  $router->get('availabilities', [
    'as' => 'api.ibooking.availability',
    'uses' => 'AvailabilityApiController@availability',
  ]);
  

// append


});
