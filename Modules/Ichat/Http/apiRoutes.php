<?php

use Illuminate\Routing\Router;

Route::prefix('/ichat/v1')->group(function (Router $router) {
    // Conversation
    require 'ApiRoutes/conversationsRoutes.php';

    // Messages
    require 'ApiRoutes/messagesRoutes.php';

    // Provider
    require 'ApiRoutes/providersRoutes.php';

    // append
});
