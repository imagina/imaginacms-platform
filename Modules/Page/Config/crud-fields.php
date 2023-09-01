<?php

return [
    'pages' => [
        'layoutId' => [
            'name' => 'layoutId',
            'value' => null,
            'type' => 'select',
            'loadOptions' => [
                'apiRoute' => '/isite/v1/layouts',
                'select' => ['label' => 'title', 'id' => 'id'],
                'requestParams' => ['filter' => ['entity_name' => 'Page', 'module_name' => 'Page']],
            ],
            'props' => [
                'label' => 'page::common.layouts.label_pages',
                'entityId' => null,
            ],
        ],
        'secondaryimage' => [
            'value' => (object) [],
            'name' => 'mediasSingle',
            'type' => 'media',
            'props' => [
                'label' => 'Imagen Secundaria',
                'zone' => 'secondaryimage',
                'entity' => "Modules\Page\Entities\Page",
                'entityId' => null,
            ],
        ],
        'breadcrumbimage' => [
            'value' => (object) [],
            'name' => 'mediasSingle',
            'type' => 'media',
            'props' => [
                'label' => 'Imagen Breadcrumb',
                'zone' => 'breadcrumbimage',
                'entity' => "Modules\Page\Entities\Page",
                'entityId' => null,
            ],
        ],
        'galleryimage' => [
            'value' => (object) [],
            'name' => 'mediasMulti',
            'type' => 'media',
            'props' => [
                'label' => 'page::common.labelGallery',
                'zone' => 'gallery',
                'entity' => "Modules\Page\Entities\Page",
                'entityId' => null,
            ],
        ],
    ],
];
