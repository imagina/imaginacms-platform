<?php

return [
  //Extra field to crud categories
  'categories' => [
    'iconimage' => [
      'value' => (object)[],
      'name' => 'mediasSingle',
      'type' => 'media',
      'props' => [
        'label' => 'Icono Menú',
        'zone' => 'iconimage',
        'entity' => "Modules\Iblog\Entities\Category",
        'entityId' => null
      ]
    ],
    'breadcrumbimage' => [
      'value' => (object)[],
      'name' => 'mediasSingle',
      'type' => 'media',
      'props' => [
        'label' => 'Imagen Breadcrumb',
        'zone' => 'breadcrumbimage',
        'entity' => "Modules\Iblog\Entities\Category",
        'entityId' => null
      ]
    ],
    'layoutId' => [
      'name' => 'layoutId',
      'value' => null,
      'type' => 'select',
      'loadOptions' => [
        'apiRoute' => '/isite/v1/layouts',
        'select' => ['label' => 'title', 'id' => 'id'],
        'requestParams' => ['filter' => ['entity_name' => 'Category', 'module_name' => 'Iblog']],
      ],
      'props' => [
        'label' => 'iblog::common.layouts.label_categories',
        'entityId' => null,
      ],
    ],
  ],
  //Extra field to crud post
  'posts' => [
    'urlCoder' => [
      'value' => "categoryAndPostSlug",
      'isFakeField' => true,
      'name' => 'urlCoder',
      'type' => 'select',
      'props' => [
        'label' => 'iblog::common.crudFieldsLabels.urlCoder',
        'multiple' => false,
        'hint' => 'iblog::common.crudFieldsHints.urlCoder',
        'options' => [
          ['label' => 'slug-categoría/slug-entrada', 'value' => "categoryAndPostSlug"],
          ['label' => 'slug-entrada', 'value' => "onlyPost"]
        ]
      ]
    ],
    'breadcrumbimage' => [
      'value' => (object)[],
      'name' => 'mediasSingle',
      'type' => 'media',
      'props' => [
        'label' => 'Imagen Breadcrumb',
        'zone' => 'breadcrumbimage',
        'entity' => "Modules\Iblog\Entities\Post",
        'entityId' => null
      ]
    ],
    'secondaryimage' => [
      'value' => (object)[],
      'name' => 'mediasSingle',
      'type' => 'media',
      'props' => [
        'label' => 'Imagen Secundaria',
        'zone' => 'secondaryimage',
        'entity' => "Modules\Iblog\Entities\Post",
        'entityId' => null
      ]
    ],
    'layoutId' => [
      'name' => 'layoutId',
      'value' => null,
      'type' => 'select',
      'loadOptions' => [
        'apiRoute' => '/isite/v1/layouts',
        'select' => ['label' => 'title', 'id' => 'id'],
        'requestParams' => ['filter' => ['entity_name' => 'Post', 'module_name' => 'Iblog']],
      ],
      'props' => [
        'label' => 'iblog::common.layouts.label_posts',
        'entityId' => null,
      ],
    ],
//    'valueIdFieldTimeLine' => [
//      'name' => 'valueIdFieldTimeLine',
//      'value' => null,
//      'type' => 'input',
//      'isFakeField' => true,
//      'props' => [
//        'label' => 'iblog::common.crudFields.labelValueIdFieldTimeLine'
//      ],
//    ],
  ]
];
