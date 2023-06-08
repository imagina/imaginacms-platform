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
        'mainimage' => [
          'value' => (object)[],
          'name' => 'mediasSingle',
          'type' => 'media',
          'props' => [
            'label' => 'Image',
            'zone' => 'mainimage',
            'entity' => "Modules\Icommerce\Entities\PaymentMethod",
            'entityId' => null
          ]
        ],
        'init' => [
            'value' => 'Modules\Icommercewompi\Http\Controllers\Api\IcommerceWompiApiController',
            'name' => 'init',
            'isFakeField' => true
        ],
        'publicKey' => [
          'value' => null,
            'name' => 'publicKey',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercewompi::icommercewompis.table.publicKey'
            ]
        ],
        'privateKey' => [
          'value' => null,
            'name' => 'privateKey',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercewompi::icommercewompis.table.privateKey'
            ]
        ],
        'eventSecretKey' => [
          'value' => null,
            'name' => 'eventSecretKey',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercewompi::icommercewompis.table.eventSecretKey'
            ]
        ],
        'showInCurrencies' => [
          'value' => ['COP'],
          'name' => 'showInCurrencies',
          'isFakeField' => true,
          'type' => 'select',
          'props' => [
            'label' => 'icommerce::paymentmethods.messages.showInCurrencies',
            'useInput' => false,
            'useChips' => false,
            'multiple' => true,
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'options' =>  [
              ['label' => 'COP','value' => 'COP']
            ]
          ]
        ],
        'mode' => [
            'value' => 'sandbox',
            'name' => 'mode',
            'isFakeField' => true,
            'type' => 'select',
            'props' => [
              'label' => 'icommercewompi::icommercewompis.table.mode',
              'useInput' => false,
              'useChips' => false,
              'multiple' => false,
              'hideDropdownIcon' => true,
              'newValueMode' => 'add-unique',
              'options' => [
                ['label' => 'Sandbox','value' => 'sandbox'],
                ['label' => 'Live','value' => 'live'],
              ]
            ]
        ],
        'minimunAmount' => [
          'value' => null,
          'name' => 'minimunAmount',
          'isFakeField' => true,
          'type' => 'input',
          'props' => [
                'label' => 'icommerce::common.minimum Amount'
          ]
        ]

  ]

];