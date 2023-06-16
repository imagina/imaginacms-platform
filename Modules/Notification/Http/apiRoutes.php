<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->post('notification/mark-read',
    ['as' => 'api.notification.read',
        'uses' => 'NotificationsController@markAsRead',
    ]);

Route::prefix('/notification/v1')->group(function (Router $router) {
    //====== Notifications
    require_once 'ApiRoutes/notificationRoutes.php';

    //====== Providers
    require_once 'ApiRoutes/providerRoutes.php';

    //====== Rules
    require_once 'ApiRoutes/ruleRoutes.php';

    //====== Templates
    require_once 'ApiRoutes/templateRoutes.php';
});
