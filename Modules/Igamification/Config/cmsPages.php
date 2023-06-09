<?php

return [
    'admin' => [
        'activities' => [
            'permission' => 'igamification.activities.manage',
            'activated' => true,
            'authenticated' => true,
            'path' => '/gamification/activities/index',
            'name' => 'qgamification.admin.activities',
            'crud' => 'qgamification/_crud/activities',
            'page' => 'qcrud/_pages/admin/crudPage',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'igamification.cms.sidebar.adminActivities',
            'icon' => 'fal fa-dice',
            'subHeader' => [
                'refresh' => true,
            ],
        ],
        'categories' => [
            'permission' => 'igamification.categories.manage',
            'activated' => true,
            'authenticated' => true,
            'path' => '/gamification/categories/index',
            'name' => 'gamification.admin.categories',
            'crud' => 'qgamification/_crud/categories',
            'page' => 'qcrud/_pages/admin/crudPage',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'igamification.cms.sidebar.adminCategories',
            'icon' => 'fal fa-layer-group',
            'subHeader' => [
                'refresh' => true,
            ],
        ],
    ],
    'panel' => [],
    'main' => [],
];
