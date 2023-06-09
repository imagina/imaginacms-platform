<?php

$transPrefix = 'iblog::gamification';

return [
    'categories' => [],
    'activities' => [
        [
            'systemName' => 'admin_home_actions_createPost',
            'title' => "$transPrefix.activities.createPost",
            'description' => "$transPrefix.activities.createPostDescription",
            'type' => 1,
            'url' => 'iadmin/#/blog/posts/index?create=call',
            'categoryId' => 'admin_home_actions',
            'icon' => 'fa-light fa-blog',
            'roles' => [],
        ],
    ],
];
