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
    'galleryimage' => [
      'value' => (object)[],
      'name' => 'medias_multi',
      'type' => 'media',
      'props' => [
        'label' => 'page::common.labelGallery',
        'zone' => 'gallery',
        'entity' => "Modules\Page\Entities\Page",
        'entityId' => null
      ]
    ]
  ],
];
