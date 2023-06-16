<?php

use Illuminate\Routing\Router;

$locale = LaravelLocalization::setLocale() ?: App::getLocale();

/** @var Router $router */
$router->get(trans('icommercepricelist::routes.pricelists.index', [], $locale), [
    'as' => $locale.'.icommercepricelist.pricelists.index',
    'uses' => 'PriceListController@index',
]);
