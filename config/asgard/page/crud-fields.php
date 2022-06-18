<?php

return [
  'pages' => [
    'breadcrumbimage' => [
      'value' => (object)[],
      'name' => 'mediasSingle',
      'type' => 'media',
      'props' => [
        'label' => 'Imagen Breadcrumb',
        'zone' => 'breadcrumbimage',
        'entity' => "Modules\Page\Entities\Page",
        'entityId' => null
      ]
    ],
    
    'gallery' => [
      'value' => (object)[],
      'name' => 'multiple',
      'type' => 'media',
      'props' => [
        'label' => 'Galería',
        'zone' => 'gallery',
        'entity' => "Modules\Page\Entities\Page",
        'entityId' => null
      ]
    ]
  ]
];
