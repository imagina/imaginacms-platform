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
            'value' => 'Modules\Icommercepaypal\Http\Controllers\Api\IcommercePaypalApiController',
            'name' => 'init',
            'isFakeField' => true,
        ],
        'clientId' => [
            'value' => null,
            'name' => 'clientId',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercepaypal::icommercepaypals.table.clientId',
            ],
        ],
        'clientSecret' => [
            'value' => null,
            'name' => 'clientSecret',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommercepaypal::icommercepaypals.table.clientSecret',
            ],
        ],
        'showInCurrencies' => [
            'value' => ['USD'],
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
                'options' => config('asgard.icommercepaypal.config.currencies'),
            ],
        ],
        'mode' => [
            'value' => 'sandbox',
            'name' => 'mode',
            'isFakeField' => true,
            'type' => 'select',
            'props' => [
                'label' => 'icommercepaypal::icommercepaypals.table.mode',
                'useInput' => false,
                'useChips' => false,
                'multiple' => false,
                'hideDropdownIcon' => true,
                'newValueMode' => 'add-unique',
                'options' => [
                    ['label' => 'Sandbox', 'value' => 'sandbox'],
                    ['label' => 'Live', 'value' => 'live'],
                ],
            ],
        ],
        'currency' => [
            'value' => 'USD',
            'name' => 'currency',
            'isFakeField' => true,
            'type' => 'select',
            'props' => [
                'label' => 'icommercepaypal::icommercepaypals.table.currency',
                'useInput' => false,
                'useChips' => false,
                'multiple' => false,
                'hideDropdownIcon' => true,
                'newValueMode' => 'add-unique',
                'options' => config('asgard.icommercepaypal.config.currencies'),
            ],
        ],
        'minimunAmount' => [
            'value' => 0,
            'name' => 'minimunAmount',
            'isFakeField' => true,
            'type' => 'input',
            'props' => [
                'label' => 'icommerce::common.minimum Amount',
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
