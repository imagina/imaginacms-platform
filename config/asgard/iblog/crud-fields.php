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
    ]
  ],
  //Extra field to crud post
  'posts' => [
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
    ]
  ]
];
