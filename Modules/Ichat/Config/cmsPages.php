<?php

return [
    'admin' => [
        'conversations' => [
            'permission' => 'ichat.conversations.manage',
            'activated' => true,
            'authenticated' => true,
            'path' => '/ichat/conversations',
            'name' => 'qchat.admin.conversations',
            'page' => 'qchat/_pages/main/conversations',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'ichat.cms.sidebar.conversations',
            'icon' => 'far fa-comments',
        ],
    ],
    'panel' => [],
    'main' => [],
];
