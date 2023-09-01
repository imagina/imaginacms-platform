<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->get('ichat/attachment/{conversationId}/{messageId}/{attachmentId}', [
    'as' => 'ichat.message.attachment',
    'uses' => 'PublicController@getAttachment',
    'middleware' => 'logged.in',
]);
