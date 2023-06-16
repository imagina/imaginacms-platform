<?php

return [
    'admin' => [
        'pages' => [
            'permission' => 'page.pages.manage',
            'activated' => true,
            'authenticated' => true,
            'path' => '/page/pages/index',
            'name' => 'qpage.admin.pages',
            'crud' => 'qpage/_crud/pages',
            'page' => 'qcrud/_pages/admin/crudPage',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'page.cms.sidebar.adminPages',
            'icon' => 'fas fa-columns',
            'subHeader' => [
                'refresh' => true,
            ],
        ],
    ],
    'panel' => [],
    'main' => [],
];
