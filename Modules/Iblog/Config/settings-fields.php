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
    'value' => (object)['iblog::defaultImageBlogBreadcrumb' => null],
    'name' => 'medias_single',
    'fakeFieldName' => 'iblog::defaultImageBlogBreadcrumb',
    'type' => 'media',
    'props' => [
      'label' => 'iblog::common.settings.defaultImageBlogBreadcrumb',
      'zone' => 'iblog::defaultImageBlogBreadcrumb',
      'entity' => "Modules\Setting\Entities\Setting",
      'entityId' => null
    ]
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
      'requestParams' => ['filter' => ['entity_name' => 'Category', 'module_name' => 'Iblog']],
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
];
