<?php

return [
    'admin' => [
        'categories' => [
            'permission' => 'idocs.categories.manage',
            'activated' => true,
            'authenticated' => true,
            'path' => '/document/categories',
            'name' => 'qdocument.admin.categories',
            'crud' => 'qdocument/_crud/categories',
            'page' => 'qcrud/_pages/admin/crudPage',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'idocs.cms.sidebar.adminCategories',
            'icon' => 'fas fa-layer-group',
            'subHeader' => [
                'refresh' => true,
            ],
        ],
    ],
    'panel' => [],
    'main' => [
        'documents' => [
            'permission' => 'idocs.documents.manage',
            'activated' => true,
            'authenticated' => true,
            'path' => '/document/documents',
            'name' => 'qdocument.admin.documents',
            'crud' => 'qdocument/_crud/documents',
            'page' => 'qcrud/_pages/admin/crudPage',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'idocs.cms.sidebar.adminDocuments',
            'icon' => 'fas fa-folder-open',
            'subHeader' => [
                'refresh' => true,
            ],
        ],
    ],
];
