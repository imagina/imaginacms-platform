<?php

return [
    'name' => 'Icommercepayu',
    'paymentName' => 'icommercepayu',
    /*
    * Crud Fields To Frontend
    */
    'crudFields' => [
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
        'image' => [
          'value' => (object)[],
          'name' => 'mediasSingle',
          'type' => 'media',
          'props' => [
            'label' => 'Image',
            'zone' => 'image',
            'entity' => "Modules\Icommerce\Entities\PaymentMethod",
            'entityId' => null
          ]
        ],
        'init' => [
            'value' => 'Modules\Icommercepayu\Http\Controllers\Api\IcommercePayuApiController',
            'name' => 'init',
            'isFakeField' => true
        ],
        'merchantId' => [
        	'value' => null,
            'name' => 'merchantId',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercepayu::icommercepayus.table.merchantId'
            ]
        ],
        'apiLogin' => [
        	'value' => null,
            'name' => 'apiLogin',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercepayu::icommercepayus.table.apilogin'
            ]
        ],
        'apiKey' => [
        	'value' => null,
            'name' => 'apiKey',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercepayu::icommercepayus.table.apiKey'
            ]
        ],
        'accountId' => [
        	'value' => null,
            'name' => 'accountId',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercepayu::icommercepayus.table.accountId'
            ]
        ],
        'mode' => [
            'value' => 'sandbox',
            'name' => 'mode',
            'isFakeField' => true,
            'type' => 'select',
            'props' => [
              'label' => 'icommercepayu::icommercepayus.table.mode',
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
        'test' => [
            'value' => null,
            'name' => 'test',
            'isFakeField' => true,
            'type' => 'select',
            'props' => [
              'label' => 'icommercepayu::icommercepayus.table.test',
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


    ],
];
