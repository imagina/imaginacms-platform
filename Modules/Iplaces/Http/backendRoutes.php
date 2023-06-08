<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => 'iplaces'], function (Router $router) {

    $router->group(['prefix' => 'places'], function (Router $router) {
        $router->bind('place', function ($id) {
            return app('Modules\Iplaces\Repositories\PlaceRepository')->find($id);
        });
        $router->get('/', [
            'as' => 'admin.iplaces.place.index',
            'uses' => 'PlaceController@index',
            'middleware' => 'can:iplaces.places.index'
        ]);
        $router->get('create', [
           // dd('hgh'),
            'as' => 'admin.iplaces.place.create',
            'uses' => 'PlaceController@create',
            'middleware' => 'can:iplaces.places.create'
        ]);
        $router->post('/', [
            'as' => 'admin.iplaces.place.store',
            'uses' => 'PlaceController@store',
            'middleware' => 'can:iplaces.places.create'
        ]);
        $router->get('{place}/edit', [
            'as' => 'admin.iplaces.place.edit',
            'uses' => 'PlaceController@edit',
            'middleware' => 'can:iplaces.places.edit'
        ]);
        $router->put('{place}', [
            'as' => 'admin.iplaces.place.update',
            'uses' => 'PlaceController@update',
            'middleware' => 'can:iplaces.places.edit'
        ]);
        $router->delete('{place}', [
            'as' => 'admin.iplaces.place.destroy',
            'uses' => 'PlaceController@destroy',
            'middleware' => 'can:iplaces.places.destroy'
        ]);
        $router->post('/{place_id}/addposts', [
            'as' => 'admin.ibusiness.userbusiness.addPosts',
            'uses' => 'PlaceController@addPosts'
        ]);
        $router->post('gallery', [
            'as' => 'iplaces.places.gallery.store',
            'uses' => 'PlaceController@galleryStore',
            //'middleware' => ['api.token','token-can:iplaces.places.create']
        ]);
        $router->post('gallery/delete', [
            'as' => 'iplaces.places.gallery.delete',
            'uses' => 'PlaceController@galleryDelete',
            // 'middleware' => ['api.token','token-can:iplaces.places.create']
        ]);
    });

    $router->group(['prefix' => 'categories'], function (Router $router) {
        $router->bind('category', function ($id) {
            return app('Modules\Iplaces\Repositories\CategoryRepository')->find($id);
        });
        $router->get('/', [
            'as' => 'admin.iplaces.category.index',
            'uses' => 'CategoryController@index',
            'middleware' => 'can:iplaces.categories.index'
        ]);
        $router->get('create', [
            'as' => 'admin.iplaces.category.create',
            'uses' => 'CategoryController@create',
            'middleware' => 'can:iplaces.categories.create'
        ]);
        $router->post('', [
            'as' => 'admin.iplaces.category.store',
            'uses' => 'CategoryController@store',
            'middleware' => 'can:iplaces.categories.create'
        ]);
        $router->get('{category}/edit', [
            'as' => 'admin.iplaces.category.edit',
            'uses' => 'CategoryController@edit',
            'middleware' => 'can:iplaces.categories.edit'
        ]);
        $router->put('{category}', [
            'as' => 'admin.iplaces.category.update',
            'uses' => 'CategoryController@update',
            'middleware' => 'can:iplaces.categories.edit'
        ]);
        $router->delete('{category}', [
            'as' => 'admin.iplaces.category.destroy',
            'uses' => 'CategoryController@destroy',
            'middleware' => 'can:iplaces.categories.destroy'
        ]);
    });

    $router->group(['prefix' => 'services'], function (Router $router) {

        $router->bind('iplacesaservice', function ($id) {
            return app('Modules\Iplaces\Repositories\ServiceRepository')->find($id);
        });
        $router->get('/', [
            'as' => 'admin.iplaces.service.index',
            'uses' => 'ServiceController@index',
            'middleware' => 'can:iplaces.services.index'
        ]);
        $router->get('create', [
            'as' => 'admin.iplaces.service.create',
            'uses' => 'ServiceController@create',
            'middleware' => 'can:iplaces.services.create'
        ]);
        $router->post('/', [
            'as' => 'admin.iplaces.service.store',
            'uses' => 'ServiceController@store',
            'middleware' => 'can:iplaces.services.create'
        ]);
        $router->get('{iplacesaservice}/edit', [
            'as' => 'admin.iplaces.service.edit',
            'uses' => 'ServiceController@edit',
            'middleware' => 'can:iplaces.services.edit'
        ]);
        $router->put('{iplacesaservice}', [
            'as' => 'admin.iplaces.service.update',
            'uses' => 'ServiceController@update',
            'middleware' => 'can:iplaces.services.edit'
        ]);
        $router->delete('{iplacesaservice}', [
            'as' => 'admin.iplaces.service.destroy',
            'uses' => 'ServiceController@destroy',
            'middleware' => 'can:iplaces.services.destroy'
        ]);

    });

    $router->group(['prefix' => 'zones'], function (Router $router) {

        $router->bind('zone', function ($id) {
            return app('Modules\Iplaces\Repositories\ZoneRepository')->find($id);
        });
        $router->get('/', [
            'as' => 'admin.iplaces.zone.index',
            'uses' => 'ZoneController@index',
            'middleware' => 'can:iplaces.zones.index'
        ]);
        $router->get('create', [
            'as' => 'admin.iplaces.zone.create',
            'uses' => 'ZoneController@create',
            'middleware' => 'can:iplaces.zones.create'
        ]);
        $router->post('/', [
            'as' => 'admin.iplaces.zone.store',
            'uses' => 'ZoneController@store',
            'middleware' => 'can:iplaces.zones.create'
        ]);
        $router->get('{zone}/edit', [
            'as' => 'admin.iplaces.zone.edit',
            'uses' => 'ZoneController@edit',
            'middleware' => 'can:iplaces.zones.edit'
        ]);
        $router->put('{zone}', [
            'as' => 'admin.iplaces.zone.update',
            'uses' => 'ZoneController@update',
            'middleware' => 'can:iplaces.zones.edit'
        ]);
        $router->delete('{zone}', [
            'as' => 'admin.iplaces.zone.destroy',
            'uses' => 'ZoneController@destroy',
            'middleware' => 'can:iplaces.zones.destroy'
        ]);
    });

    $router->group(['prefix' => '/schedules'], function (Router $router) {

        $router->bind('schedule', function ($id) {
            return app('Modules\Iplaces\Repositories\ScheduleRepository')->find($id);
        });
        $router->get('/', [
            'as' => 'admin.iplaces.schedule.index',
            'uses' => 'ScheduleController@index',
            'middleware' => 'can:iplaces.schedules.index'
        ]);
        $router->get('create', [
            'as' => 'admin.iplaces.schedule.create',
            'uses' => 'ScheduleController@create',
            'middleware' => 'can:iplaces.schedules.create'
        ]);
        $router->post('/', [
            'as' => 'admin.iplaces.schedule.store',
            'uses' => 'ScheduleController@store',
            'middleware' => 'can:iplaces.schedules.create'
        ]);
        $router->get('{schedule}/edit', [
            'as' => 'admin.iplaces.schedule.edit',
            'uses' => 'ScheduleController@edit',
            'middleware' => 'can:iplaces.schedules.edit'
        ]);
        $router->put('{schedule}', [
            'as' => 'admin.iplaces.schedule.update',
            'uses' => 'ScheduleController@update',
            'middleware' => 'can:iplaces.schedules.edit'
        ]);
        $router->delete('{schedule}', [
            'as' => 'admin.iplaces.schedule.destroy',
            'uses' => 'ScheduleController@destroy',
            'middleware' => 'can:iplaces.schedules.destroy'
        ]);
        
    });

    $router->group(['prefix' => '/spaces'], function (Router $router) {

        $router->bind('space', function ($id) {
            return app('Modules\Iplaces\Repositories\SpaceRepository')->find($id);
        });
        $router->get('spaces', [
            'as' => 'admin.iplaces.space.index',
            'uses' => 'SpaceController@index',
            'middleware' => 'can:iplaces.spaces.index'
        ]);
        $router->get('spaces/create', [
            'as' => 'admin.iplaces.space.create',
            'uses' => 'SpaceController@create',
            'middleware' => 'can:iplaces.spaces.create'
        ]);
        $router->post('spaces', [
            'as' => 'admin.iplaces.space.store',
            'uses' => 'SpaceController@store',
            'middleware' => 'can:iplaces.spaces.create'
        ]);
        $router->get('spaces/{space}/edit', [
            'as' => 'admin.iplaces.space.edit',
            'uses' => 'SpaceController@edit',
            'middleware' => 'can:iplaces.spaces.edit'
        ]);
        $router->put('spaces/{space}', [
            'as' => 'admin.iplaces.space.update',
            'uses' => 'SpaceController@update',
            'middleware' => 'can:iplaces.spaces.edit'
        ]);
        $router->delete('spaces/{space}', [
            'as' => 'admin.iplaces.space.destroy',
            'uses' => 'SpaceController@destroy',
            'middleware' => 'can:iplaces.spaces.destroy'
        ]);
    
    });
    $router->group(['prefix' => '/cities'], function (Router $router) {
        $router->bind('iplacesacity', function ($id) {
            return app('Modules\Iplaces\Repositories\CityRepository')->find($id);
        });
        $router->get('/', [
            'as' => 'admin.iplaces.city.index',
            'uses' => 'CityController@index',
            'middleware' => 'can:iplaces.cities.index'
        ]);
        $router->get('create', [
            'as' => 'admin.iplaces.city.create',
            'uses' => 'CityController@create',
            'middleware' => 'can:iplaces.cities.create'
        ]);
        $router->post('/', [
            'as' => 'admin.iplaces.city.store',
            'uses' => 'CityController@store',
            'middleware' => 'can:iplaces.cities.create'
        ]);
        $router->get('{iplacesacity}/edit', [
            'as' => 'admin.iplaces.city.edit',
            'uses' => 'CityController@edit',
            'middleware' => 'can:iplaces.cities.edit'
        ]);
        $router->put('/{iplacesacity}', [
            'as' => 'admin.iplaces.city.update',
            'uses' => 'CityController@update',
            'middleware' => 'can:iplaces.cities.edit'
        ]);
        $router->delete('/{iplacesacity}', [
            'as' => 'admin.iplaces.city.destroy',
            'uses' => 'CityController@destroy',
            'middleware' => 'can:iplaces.cities.destroy'
        ]);
    });
});

