<?php

return [
    'formFields' => [
        'title' => [
            'value' => null,
            'name' => 'title',
            'type' => 'input',
            'isTranslatable' => true,
            'props' => [
                'label' => 'icommerce::common.title',
            ],
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
            ],
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
                    ['label' => 'Activo', 'value' => 1],
                    ['label' => 'Inactivo', 'value' => 0],
                ],
            ],
        ],
        'mainimage' => [
            'value' => (object) [],
            'name' => 'mediasSingle',
            'type' => 'media',
            'props' => [
                'label' => 'Image',
                'zone' => 'mainimage',
                'entity' => "Modules\Icommerce\Entities\PaymentMethod",
                'entityId' => null,
            ],
        ],
        'init' => [
            'value' => 'Modules\Icommercestripe\Http\Controllers\Api\IcommerceStripeApiController',
            'name' => 'init',
            'isFakeField' => true,
        ],
        'publicKey' => [
            'value' => null,
            'name' => 'publicKey',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercestripe::icommercestripes.table.publicKey',
            ],
        ],
        'secretKey' => [
            'value' => null,
            'name' => 'secretKey',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercestripe::icommercestripes.table.secretKey',
            ],
        ],
        'accountId' => [
            'value' => null,
            'name' => 'accountId',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercestripe::icommercestripes.table.accountId',
            ],
        ],
        'signSecret' => [
            'value' => null,
            'name' => 'signSecret',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercestripe::icommercestripes.table.signSecret',
            ],
        ],
        'currency' => [
            'value' => 'USD',
            'name' => 'currency',
            'isFakeField' => true,
            'type' => 'select',
            'props' => [
                'label' => 'icommercestripe::icommercestripes.table.currency',
                'useInput' => false,
                'useChips' => false,
                'multiple' => false,
                'hideDropdownIcon' => true,
                'newValueMode' => 'add-unique',
                'options' => config('asgard.icommercestripes.config.currencies'),
            ],
        ],
        'connectCountries' => [
            'name' => 'connectCountries',
            'value' => [],
            'isFakeField' => true,
            'type' => 'select',
            'columns' => 'col-12 col-md-6 q-pr-sm q-pt-sm',
            'props' => [
                'clearable' => true,
                'multiple' => true,
                'useChips' => true,
                'label' => 'icommercestripe::icommercestripes.table.connectCountries',
            ],
            'loadOptions' => [
                'apiRoute' => 'apiRoutes.qlocations.countries', //apiRoute to request
                'select' => ['label' => 'name', 'id' => 'iso2'], //Define fields to config select
                'requestParams' => [
                    'filter' => [
                        'indexAll' => true,
                    ],
                ],
            ],
        ],
        'comisionAmount' => [
            'value' => null,
            'name' => 'comisionAmount',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercestripe::icommercestripes.table.comisionAmount',
            ],
        ],
        /*
        'mode' => [
            'value' => 'sandbox',
            'name' => 'mode',
            'isFakeField' => true,
            'type' => 'select',
            'props' => [
              'label' => 'icommerce::common.formFields.mode',
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
        ],*/
        'showInCurrencies' => [
            'value' => ['USD', 'COP'],
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
                'options' => [
                    ['label' => 'USD', 'value' => 'USD'],
                    ['label' => 'COP', 'value' => 'COP'],
                ],
            ],
        ],
        'minimunAmount' => [
            'value' => null,
            'name' => 'minimunAmount',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercestripe::icommercestripes.table.minimunAmount',
            ],
        ],
        'maximumAmount' => [
            'value' => null,
            'name' => 'maximumAmount',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommerce::common.formFields.maximum Amount',
            ],
        ],
        'excludedUsersForMaximumAmount' => [
            'name' => 'excludedUsersForMaximumAmount',
            'value' => [],
            'type' => 'select',
            'isFakeField' => true,
            'loadOptions' => [
                'apiRoute' => 'apiRoutes.quser.users',
                'select' => ['label' => 'email', 'id' => 'id'],
            ],
            'props' => [
                'label' => 'icommerce::common.formFields.excludedUsersForMaximumAmount',
                'multiple' => true,
                'use-chips' => true,
            ],
        ],

    ],

];
