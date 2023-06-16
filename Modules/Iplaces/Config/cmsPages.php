<?php

return [
    'admin' => [
        'places' => [
            'permission' => 'iplaces.places.manage',
            'activated' => true,
            'path' => '/iplaces/places/index',
            'name' => 'qplace.admin.places.index',
            'crud' => 'qplace/_crud/places',
            'page' => 'qcrud/_pages/admin/crudPage',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'iplaces.cms.sidebar.adminPlaces',
            'icon' => 'fas fa-map-marked-alt',
            'authenticated' => true,
            'subHeader' => [
                'refresh' => true,
            ],
        ],
        'categories' => [
            'permission' => 'iplaces.categories.manage',
            'activated' => true,
            'path' => '/iplaces/categories/index',
            'name' => 'qplace.admin.categories',
            'crud' => 'qplace/_crud/categories',
            'page' => 'qcrud/_pages/admin/crudPage',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'iplaces.cms.sidebar.adminCategories',
            'icon' => 'fas fa-layer-group',
            'authenticated' => true,
            'subHeader' => [
                'refresh' => true,
            ],
        ],
    ],
    'panel' => [],
    'main' => [],
];
