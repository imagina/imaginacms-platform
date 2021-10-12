<?php

use Illuminate\Routing\Router;


$locale = LaravelLocalization::setLocale() ?: App::getLocale();

#==================================================== Partials to the Ipanel

$router->get('isite/header', [
  'as' => 'isite.header',
  'uses' => 'PublicController@header'
]);
$router->get('isite/footer', [
  'as' => 'isite.footer',
  'uses' => 'PublicController@footer'
]);
$router->get('isite/pdf', [
  'as' => 'isite.pdf',
  'uses' => 'PublicController@pdf'
]);
