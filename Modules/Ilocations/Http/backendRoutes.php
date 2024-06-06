<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/ilocations'], function (Router $router) {
    $router->bind('country', function ($id) {
        return app('Modules\Ilocations\Repositories\CountryRepository')->find($id);
    });
    $router->get('countries', [
        'as' => 'admin.ilocations.country.index',
        'uses' => 'CountryController@index',
        'middleware' => 'can:ilocations.countries.index'
    ]);
    $router->get('countries/create', [
        'as' => 'admin.ilocations.country.create',
        'uses' => 'CountryController@create',
        'middleware' => 'can:ilocations.countries.create'
    ]);
    $router->post('countries', [
        'as' => 'admin.ilocations.country.store',
        'uses' => 'CountryController@store',
        'middleware' => 'can:ilocations.countries.create'
    ]);
    $router->get('countries/{country}/edit', [
        'as' => 'admin.ilocations.country.edit',
        'uses' => 'CountryController@edit',
        'middleware' => 'can:ilocations.countries.edit'
    ]);
    $router->put('countries/{country}', [
        'as' => 'admin.ilocations.country.update',
        'uses' => 'CountryController@update',
        'middleware' => 'can:ilocations.countries.edit'
    ]);
    $router->delete('countries/{country}', [
        'as' => 'admin.ilocations.country.destroy',
        'uses' => 'CountryController@destroy',
        'middleware' => 'can:ilocations.countries.destroy'
    ]);
    $router->bind('province', function ($id) {
        return app('Modules\Ilocations\Repositories\ProvinceRepository')->find($id);
    });
    $router->get('provinces', [
        'as' => 'admin.ilocations.province.index',
        'uses' => 'ProvinceController@index',
        'middleware' => 'can:ilocations.provinces.index'
    ]);
    $router->get('provinces/create', [
        'as' => 'admin.ilocations.province.create',
        'uses' => 'ProvinceController@create',
        'middleware' => 'can:ilocations.provinces.create'
    ]);
    $router->post('provinces', [
        'as' => 'admin.ilocations.province.store',
        'uses' => 'ProvinceController@store',
        'middleware' => 'can:ilocations.provinces.create'
    ]);
    $router->get('provinces/{province}/edit', [
        'as' => 'admin.ilocations.province.edit',
        'uses' => 'ProvinceController@edit',
        'middleware' => 'can:ilocations.provinces.edit'
    ]);
    $router->put('provinces/{province}', [
        'as' => 'admin.ilocations.province.update',
        'uses' => 'ProvinceController@update',
        'middleware' => 'can:ilocations.provinces.edit'
    ]);
    $router->delete('provinces/{province}', [
        'as' => 'admin.ilocations.province.destroy',
        'uses' => 'ProvinceController@destroy',
        'middleware' => 'can:ilocations.provinces.destroy'
    ]);
    $router->bind('geozones', function ($id) {
        return app('Modules\Ilocations\Repositories\GeozonesRepository')->find($id);
    });
    $router->get('geozones', [
        'as' => 'admin.ilocations.geozones.index',
        'uses' => 'GeozonesController@index',
        'middleware' => 'can:ilocations.geozones.index'
    ]);
    $router->get('geozones/create', [
        'as' => 'admin.ilocations.geozones.create',
        'uses' => 'GeozonesController@create',
        'middleware' => 'can:ilocations.geozones.create'
    ]);
    $router->post('geozones', [
        'as' => 'admin.ilocations.geozones.store',
        'uses' => 'GeozonesController@store',
        'middleware' => 'can:ilocations.geozones.create'
    ]);
    $router->get('geozones/{geozones}/edit', [
        'as' => 'admin.ilocations.geozones.edit',
        'uses' => 'GeozonesController@edit',
        'middleware' => 'can:ilocations.geozones.edit'
    ]);
    $router->put('geozones/{geozones}', [
        'as' => 'admin.ilocations.geozones.update',
        'uses' => 'GeozonesController@update',
        'middleware' => 'can:ilocations.geozones.edit'
    ]);
    $router->delete('geozones/{geozones}', [
        'as' => 'admin.ilocations.geozones.destroy',
        'uses' => 'GeozonesController@destroy',
        'middleware' => 'can:ilocations.geozones.destroy'
    ]);
    $router->bind('city', function ($id) {
        return app('Modules\Ilocations\Repositories\CityRepository')->find($id);
    });
    $router->get('cities', [
        'as' => 'admin.ilocations.city.index',
        'uses' => 'CityController@index',
        'middleware' => 'can:ilocations.cities.index'
    ]);
    $router->get('cities/create', [
        'as' => 'admin.ilocations.city.create',
        'uses' => 'CityController@create',
        'middleware' => 'can:ilocations.cities.create'
    ]);
    $router->post('cities', [
        'as' => 'admin.ilocations.city.store',
        'uses' => 'CityController@store',
        'middleware' => 'can:ilocations.cities.create'
    ]);
    $router->get('cities/{city}/edit', [
        'as' => 'admin.ilocations.city.edit',
        'uses' => 'CityController@edit',
        'middleware' => 'can:ilocations.cities.edit'
    ]);
    $router->put('cities/{city}', [
        'as' => 'admin.ilocations.city.update',
        'uses' => 'CityController@update',
        'middleware' => 'can:ilocations.cities.edit'
    ]);
    $router->delete('cities/{city}', [
        'as' => 'admin.ilocations.city.destroy',
        'uses' => 'CityController@destroy',
        'middleware' => 'can:ilocations.cities.destroy'
    ]);
    $router->bind('polygon', function ($id) {
        return app('Modules\Ilocations\Repositories\PolygonRepository')->find($id);
    });
    $router->get('polygons', [
        'as' => 'admin.ilocations.polygon.index',
        'uses' => 'PolygonController@index',
        'middleware' => 'can:ilocations.polygons.index'
    ]);
    $router->get('polygons/create', [
        'as' => 'admin.ilocations.polygon.create',
        'uses' => 'PolygonController@create',
        'middleware' => 'can:ilocations.polygons.create'
    ]);
    $router->post('polygons', [
        'as' => 'admin.ilocations.polygon.store',
        'uses' => 'PolygonController@store',
        'middleware' => 'can:ilocations.polygons.create'
    ]);
    $router->get('polygons/{polygon}/edit', [
        'as' => 'admin.ilocations.polygon.edit',
        'uses' => 'PolygonController@edit',
        'middleware' => 'can:ilocations.polygons.edit'
    ]);
    $router->put('polygons/{polygon}', [
        'as' => 'admin.ilocations.polygon.update',
        'uses' => 'PolygonController@update',
        'middleware' => 'can:ilocations.polygons.edit'
    ]);
    $router->delete('polygons/{polygon}', [
        'as' => 'admin.ilocations.polygon.destroy',
        'uses' => 'PolygonController@destroy',
        'middleware' => 'can:ilocations.polygons.destroy'
    ]);
// append





});
