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
            'value' => 'Modules\Icommerceepayco\Http\Controllers\Api\IcommerceEpaycoApiController',
            'name' => 'init',
            'isFakeField' => true
        ],
        'publicKey' => [
          'value' => null,
            'name' => 'publicKey',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommerceepayco::icommerceepaycos.table.publicKey'
            ]
        ],
        'clientId' => [
          'value' => null,
            'name' => 'clientId',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommerceepayco::icommerceepaycos.table.clientId'
            ]
        ],
        'pKey' => [
          'value' => null,
            'name' => 'pKey',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommerceepayco::icommerceepaycos.table.pKey'
            ]
        ],
        'autoClick' => [
            'value' => true,
            'name' => 'autoClick',
            'isFakeField' => true,
            'type' => 'select',
            'props' => [
              'label' => 'icommerceepayco::icommerceepaycos.table.autoClick',
              'useInput' => false,
              'useChips' => false,
              'multiple' => false,
              'hideDropdownIcon' => true,
              'newValueMode' => 'add-unique',
              'options' => [
                ['label' => 'Yes','value' => true],
                ['label' => 'No','value' => false],
              ]
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
        'test' => [
            'value' => true,
            'name' => 'test',
            'isFakeField' => true,
            'type' => 'select',
            'props' => [
              'label' => 'icommerceepayco::icommerceepaycos.table.testMode',
              'useInput' => false,
              'useChips' => false,
              'multiple' => false,
              'hideDropdownIcon' => true,
              'newValueMode' => 'add-unique',
              'options' => [
                ['label' => 'Yes','value' => true],
                ['label' => 'No','value' => false],
              ]
            ]
        ],
        'minimunAmount' => [
          'value' => 15000,
          'name' => 'minimunAmount',
          'isFakeField' => true,
          'type' => 'input',
          'props' => [
                'label' => 'icommerce::common.minimum Amount'
          ]
        ],

  ]

];