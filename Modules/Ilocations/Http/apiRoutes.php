<?php

use Illuminate\Routing\Router;


$router->group(['prefix' => '/v2/ilocations'], function (Router $router) {

  require('ApiRoutes/CityRoutes.php');
  require('ApiRoutes/CountryRoutes.php');
  require('ApiRoutes/ProvinceRoutes.php');
  require('ApiRoutes/PolygonRoutes.php');
  require ('ApiRoutes/GeozoneRoutes.php');
  require ('ApiRoutes/NeighborhoodRoutes.php');

});


$router->group(['prefix' => '/ilocations'], function (Router $router) {

  $router->get('allfullcountries', [
    'as' => 'ilocation.api.get.allfullcountries',
    'uses' => 'CountryController@allFullCountries',
  ]);

  $router->get('allmincountries', [
    'as' => 'ilocation.api.get.allmincountries',
    'uses' => 'CountryController@allMinCountries',
  ]);

  $router->get('allprovincesbycountry/iso2/{countryCode}', [
    'as' => 'ilocation.api.get.allprovincesbycountry.iso2',
    'uses' => 'CountryController@allProvincesByCountryIso2',
  ]);

  $router->get('allprovincesbycountry/iso3/{countryCode}', [
    'as' => 'ilocation.api.get.allprovincesbycountry.iso3',
    'uses' => 'CountryController@allProvincesByCountryIso3',
  ]);
  $router->get('allcitiesbyprovince/{provinceId}', [
    'as' => 'ilocation.api.get.allcitiesbyprovince',
    'uses' => 'CountryController@allCitiesByProvinceId',
  ]);

});
