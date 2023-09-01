<?php

return [
    'admin' => [
        'redirects' => [
            'permission' => 'iredirect.redirects.manage',
            'activated' => true,
            'authenticated' => true,
            'path' => '/redirect/redirects/index',
            'name' => 'qredirect.admin.redirects',
            'crud' => 'qredirect/_crud/redirects',
            'page' => 'qcrud/_pages/admin/crudPage',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'iredirect.cms.sidebar.adminRedirects',
            'icon' => 'fas fa-random',
            'subHeader' => [
                'refresh' => true,
            ],
        ],
    ],
    'panel' => [],
    'main' => [],
];
