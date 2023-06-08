<?php

return [
    'formFields' => [
        'title' => [
            'value' => null,
            'name' => 'title',
            'type' => 'input',
						'isTranslatable' => true,
            'props' => [
                'label' => 'icommerce::common.title'
            ]
        ],
        'description' => [
            'value' => null,
            'name' => 'description',
            'type' => 'input',
					'isTranslatable' => true,
            'props' => [
                'label' => 'icommerce::common.description',
                'type' => 'textarea',
                'rows' => 3,
            ]
        ],
        'status' => [
            'value' => 0,
            'name' => 'status',
            'type' => 'select',
            'props' => [
              'label' => 'icommerce::common.status',
              'useInput' => false,
              'useChips' => false,
              'multiple' => false,
              'hideDropdownIcon' => true,
              'newValueMode' => 'add-unique',
              'options' => [
                ['label' => 'Activo','value' => 1],
                ['label' => 'Inactivo','value' => 0],
              ]
            ]
        ],
        'apiKey' => [
            'value' => null,
            'name' => 'apiKey',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'Api Key'
            ]
        ],
        'password' => [
            'value' => null,
            'name' => 'password',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'Password'
            ]
        ],
        /*
        'cityOrigin' => [
            'value' => null,
            'name' => 'cityOrigin',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'Ciudad de Origen - Codigo DANE Ibague Example: 73001000'
            ]
        ],
        */
        'cityOrigin' => [
            'value' => null,
            'name' => 'cityOrigin',
            'isFakeField' => true,
            'type' => 'select',
            'props' => [
              'clearable' => true,
              'multiple' => false,
              'label' => 'Ciudad de Origen',
            ],
            'loadOptions' => [
              'apiRoute' => 'apiRoutes.qlocations.cities',
              'select' => ['label' => 'name', 'id' => 'code'],
              'requestParams' => [
                "filter" => [
                  "indexAll" => true
                ]
              ]
            ]
        ],
        'mode' => [
            'value' => 'sandbox',
            'name' => 'mode',
            'isFakeField' => true,
            'type' => 'select',
            'props' => [
              'label' => 'Mode',
              'useInput' => false,
              'useChips' => false,
              'multiple' => false,
              'hideDropdownIcon' => true,
              'newValueMode' => 'add-unique',
              'options' => [
                ['label' => 'Sandbox','value' => 'sandbox'],
                ['label' => 'Production','value' => 'production'],
              ]
            ]
        ],
        'mainimage' => [
          'value' => (object)[],
          'name' => 'mediasSingle',
          'type' => 'media',
          'props' => [
            'label' => 'Image',
            'zone' => 'mainimage',
            'entity' => "Modules\Icommerce\Entities\ShippingMethod",
            'entityId' => null
          ]
        ],
        'init' => [
            'value' => 'Modules\Icommercecoordinadora\Http\Controllers\Api\IcommerceCoordinadoraApiController',
            'name' => 'init',
            'isFakeField' => true
        ]
    ],
];
