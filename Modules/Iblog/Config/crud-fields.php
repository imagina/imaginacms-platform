<?php

return [
  //Extra field to crud categories
  'categories' => [
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
