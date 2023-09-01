<?php

return [
    'posts-per-page' => [
        'name' => 'iblog::posts-per-page',
        'value' => null,
        'type' => 'input',
        'props' => [
            'label' => 'iblog::settings.posts-per-page',
            'type' => 'number',
        ],
    ],

    'defaultImageBlogBreadcrumb' => [
        'value' => (object) ['iblog::defaultImageBlogBreadcrumb' => null],
        'name' => 'medias_single',
        'fakeFieldName' => 'iblog::defaultImageBlogBreadcrumb',
        'type' => 'media',
        'props' => [
            'label' => 'iblog::common.settings.defaultImageBlogBreadcrumb',
            'zone' => 'iblog::defaultImageBlogBreadcrumb',
            'entity' => "Modules\Setting\Entities\Setting",
            'entityId' => null,
        ],
    ],
    'layoutPostBlog' => [
        'name' => 'iblog::layoutPostBlog',
        'value' => null,
        'type' => 'select',
        'groupName' => 'layouts',
        'groupTitle' => 'iblog::common.layouts.group_name',
        'loadOptions' => [
            'apiRoute' => '/isite/v1/layouts',
            'select' => ['label' => 'title', 'id' => 'path'],
            'requestParams' => ['filter' => ['entity_name' => 'Post', 'module_name' => 'Iblog']],
        ],
        'props' => [
            'label' => 'iblog::common.layouts.label_posts',
            'entityId' => null,
        ],
    ],
    'layoutCategoryBlog' => [
        'name' => 'iblog::layoutCategoryBlog',
        'value' => null,
        'type' => 'select',
        'groupName' => 'layouts',
        'groupTitle' => 'iblog::common.layouts.group_name',
        'loadOptions' => [
            'apiRoute' => '/isite/v1/layouts',
            'select' => ['label' => 'title', 'id' => 'path'],
            'requestParams' => ['filter' => ['entity_name' => 'Category', 'module_name' => 'Iblog']],
        ],
        'props' => [
            'label' => 'iblog::common.layouts.label_categories',
            'entityId' => null,
        ],
    ],
    'orderSearchResults' => [
        'value' => ['scoreSearch1', 'iblog__posts.created_at', 'scoreSearch2'],
        'name' => 'iblog::orderSearchResults',
        'groupName' => 'searcher',
        'groupTitle' => 'iblog::common.groups.searcher',
        'onlySuperAdmin' => true,
        'type' => 'select',
        'columns' => 'col-6',
        'props' => [
            'label' => 'iblog::common.settings.searcherOrder',
            'useInput' => false,
            'useChips' => true,
            'multiple' => true,
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'options' => [
                ['label' => 'Palabra completa', 'value' => 'scoreSearch1'],
                ['label' => 'Fecha de Creación', 'value' => 'iblog__posts.created_at'],
                ['label' => 'Palabras individuales', 'value' => 'scoreSearch2'],
            ],
        ],
    ],
    'selectSearchFieldsPosts' => [
        'value' => ['title', 'summary', 'description'],
        'name' => 'iblog::selectSearchFieldsPosts',
        'groupName' => 'searcher',
        'groupTitle' => 'iblog::common.groups.searcher',
        'onlySuperAdmin' => true,
        'type' => 'select',
        'columns' => 'col-6',
        'props' => [
            'label' => 'iblog::common.settings.searchFields',
            'useInput' => false,
            'useChips' => true,
            'multiple' => true,
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'options' => [
                ['label' => 'iblog::common.settings.options.title', 'value' => 'title'],
                ['label' => 'iblog::common.settings.options.summary', 'value' => 'summary'],
                ['label' => 'iblog::common.settings.options.description', 'value' => 'description'],
            ],
        ],
    ],
    'arrayItemComponentsAttributesBlog' => [
        'value' => [],
        'name' => 'iblog::arrayItemComponentsAttributesBlog',
        'type' => 'json',
        'onlySuperAdmin' => true,
        'groupName' => 'layouts',
        'groupTitle' => 'iblog::common.layouts.group_name',
        'colClass' => 'col-12 col-md-12',
        'props' => [
            'label' => 'iblog::common.layouts.labelArrayItemComponentsAttributesBlog',
            'rows' => 12,
        ],
    ],
];
