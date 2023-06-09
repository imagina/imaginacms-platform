<?php

return [
    'admin' => [
        'events' => [
            'permission' => 'ievent.events.manage',
            'activated' => true,
            'authenticated' => true,
            'path' => '/event/events',
            'name' => 'qevent.admin.events',
            'page' => 'qevent/_pages/admin/events/index',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'ievent.cms.sidebar.adminEvents',
            'icon' => 'fas fa-calendar-check',
            'subHeader' => [
                'refresh' => true,
            ],
        ],
        'categories' => [
            'permission' => 'ievent.categories.manage',
            'activated' => true,
            'authenticated' => true,
            'path' => '/event/categories',
            'name' => 'qevent.admin.categories',
            'crud' => 'qevent/_crud/categories',
            'page' => 'qcrud/_pages/admin/crudPage.vue',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'ievent.cms.sidebar.adminCategories',
            'icon' => 'fas fa-calendar-week',
            'subHeader' => [
                'refresh' => true,
            ],
        ],
    ],
    'panel' => [],
    'main' => [],
];
