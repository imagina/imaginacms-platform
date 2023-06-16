<?php

use Illuminate\Routing\Router;

/** @var Router $router */
(! empty(json_decode(setting('isite::rolesToTenant', null, '[]')))) ?
  $middlewares = [
      'universal',
      \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class,
      \Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain::class,
  ] :
  $middlewares = [];

$router->get('/', [
    'uses' => 'PublicController@homepage',
    'as' => locale().'.homepage',
    'middleware' => $middlewares,
]);
