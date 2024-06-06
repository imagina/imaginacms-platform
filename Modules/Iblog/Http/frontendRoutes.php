<?php

use Illuminate\Routing\Router;

$locale = LaravelLocalization::setLocale() ?: App::getLocale();

if (!App::runningInConsole()) {
    $categoryRepository = app('Modules\Iblog\Repositories\CategoryRepository');
    $categories = $categoryRepository->getItemsBy(json_decode(json_encode(['filter' => [], 'include' => [], 'take' => null])));
    foreach ($categories as $category) {

        /** @var Router $router */
        $router->group(['prefix' => $category->slug], function (Router $router) use ($locale, $category) {

            $router->get('/', [
                'as' => $locale . '.iblog.category.' . $category->slug,
                'uses' => 'PublicController@index',
                'middleware' => config('asgard.iblog.config.middleware'),
            ]);
            $router->get('{slug}', [
                'as' => $locale . '.iblog.' . $category->slug . '.post',
                'uses' => 'PublicController@show',
                'middleware' => config('asgard.iblog.config.middleware'),
            ]);
        });
    }
}
/** @var Router $router */
$router->group(['prefix' => trans('iblog::tag.uri')], function (Router $router) use ($locale) {
    $router->get('{slug}', [
        'as' => $locale . '.iblog.tag.slug',
        'uses' => 'PublicController@tag',
        //'middleware' => config('asgard.iblog.config.middleware'),
    ]);
});


/** @var Router $router */
$router->group(['prefix' => 'iblog/feed'], function (Router $router) use ($locale) {
    $router->get('{format}', [
        'as' => $locale . '.iblog.feed.format',
        'uses' => 'PublicController@feed',

    ]);
});
