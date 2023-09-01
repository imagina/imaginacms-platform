<?php

return [
    'admin' => [
        'translations' => [
            'permission' => 'translation.translations.manage',
            'activated' => true,
            'authenticated' => true,
            'path' => '/translations/index',
            'name' => 'qtranslation.admin.translations',
            'crud' => 'qtranslation/_crud/translations',
            'page' => 'qcrud/_pages/admin/crudPage',
            'layout' => 'qsite/_layouts/master.vue',
            'title' => 'translation.cms.sidebar.adminTranslations',
            'icon' => 'fas fa-language',
            'subHeader' => [
                'refresh' => true,
            ],
        ],
    ],
    'panel' => [],
    'main' => [],
];
