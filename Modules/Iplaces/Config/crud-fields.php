<?php

return [
    'places' => [
        'whatsapp1CallingCode' => [
            'name' => 'whatsapp1CallingCode',
            'value' => null,
            'type' => 'select',
            'columns' => 'col-6 col-xl-2 q-pr-sm q-pt-sm',
            'fakeFieldName' => 'options',
            'isFakeField' => true,
            'props' => [
                'label' => 'iplaces::common.crudFields.label-whatsapp1CallingCode',
            ],
            'loadOptions' => [
                'apiRoute' => 'apiRoutes.qlocations.countries', //apiRoute to request
                'select' => ['label' => 'name', 'id' => 'callingCode'], //Define fields to config select
            ],
        ],
        'whatsapp1Number' => [
            'name' => 'whatsapp1Number',
            'value' => null,
            'type' => 'input',
            'columns' => 'col-6 col-xl-2 q-pr-sm q-pt-sm',
            'fakeFieldName' => 'options',
            'isFakeField' => true,
            'props' => [
                'label' => 'iplaces::common.crudFields.label-whatsapp1Number',
                'type' => 'number',
            ],
        ],
        'whatsapp1Message' => [
            'name' => 'whatsapp1Message',
            'value' => null,
            'type' => 'input',
            'columns' => 'col-12 col-xl-3 q-pr-sm q-pt-sm',
            'fakeFieldName' => 'options',
            'isFakeField' => true,
            'props' => [
                'label' => 'iplaces::common.crudFields.label-whatsapp1Message',
            ],
        ],
        'whatsapp2CallingCode' => [
            'name' => 'whatsapp2CallingCode',
            'value' => null,
            'type' => 'select',
            'columns' => 'col-6 col-xl-2 q-pr-sm q-pt-sm',
            'fakeFieldName' => 'options',
            'isFakeField' => true,
            'props' => [
                'label' => 'iplaces::common.crudFields.label-whatsapp2CallingCode',
            ],
            'loadOptions' => [
                'apiRoute' => 'apiRoutes.qlocations.countries', //apiRoute to request
                'select' => ['label' => 'name', 'id' => 'callingCode'], //Define fields to config select
            ],
        ],
        'whatsapp2Number' => [
            'name' => 'whatsapp2Number',
            'value' => null,
            'type' => 'input',
            'columns' => 'col-6 col-xl-2 q-pr-sm q-pt-sm',
            'fakeFieldName' => 'options',
            'isFakeField' => true,
            'props' => [
                'label' => 'iplaces::common.crudFields.label-whatsapp2Number',
                'type' => 'number',
            ],
        ],
        'whatsapp2Message' => [
            'name' => 'whatsapp1Message',
            'value' => null,
            'type' => 'input',
            'columns' => 'col-12 col-xl-3 q-pr-sm q-pt-sm',
            'fakeFieldName' => 'options',
            'isFakeField' => true,
            'props' => [
                'label' => 'iplaces::common.crudFields.label-whatsapp2Message',
            ],
        ],
        'addressIplace' => [
            'name' => 'addressIplace',
            'value' => null,
            'type' => 'input',
            'fakeFieldName' => 'options',
            'isFakeField' => true,
            'props' => [
                'label' => 'iplaces::common.crudFields.label-addressIplace',
                'type' => 'text',
            ],
        ],
        'breadcrumbimage' => [
            'value' => (object) [],
            'name' => 'mediasSingle',
            'type' => 'media',
            'props' => [
                'label' => 'Imagen Breadcrumb',
                'zone' => 'breadcrumbimage',
                'entity' => "Modules\Iplaces\Entities\Place",
                'entityId' => null,
            ],
        ],
    ],
    'categories' => [
        'breadcrumbimage' => [
            'value' => (object) [],
            'name' => 'mediasSingle',
            'type' => 'media',
            'props' => [
                'label' => 'Imagen Breadcrumb',
                'zone' => 'breadcrumbimage',
                'entity' => "Modules\Iplaces\Entities\Category",
                'entityId' => null,
            ],
        ],
    ],
];
