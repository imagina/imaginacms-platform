<?php

return [
    'plans' => [
        'url' => [
            'name' => 'url',
            'value' => null,
            'type' => 'input',
            'fakeFieldName' => 'options',
            'isFakeField' => true,
            'props' => [
                'label' => 'iplan::common.crudFields.url',
                'type' => 'url',
            ],
        ],
        'transactionFeeType' => [
            'name' => 'transactionFeeType',
            'isFakeField' => true,
            'value' => null,
            'type' => 'select',
            'props' => [
                'label' => 'Transaction Fee Type',
                'multiple' => false,
                'options' => [
                    ['label' => 'Percentage', 'value' => 'percentage'],
                    ['label' => 'Fixed', 'value' => 'fixed'],
                ],
            ],
        ],
        'transactionFeeAmount' => [
            'name' => 'transactionFeeAmount',
            'isFakeField' => true,
            'value' => null,
            'type' => 'input',
            'props' => [
                'label' => 'Transaction Fee Amount',

            ],
        ],
    ],
];
