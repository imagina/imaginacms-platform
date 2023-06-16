<?php

return [
    'availableCountries' => [
        'name' => 'ilocations::availableCountries',
        'value' => [],
        'type' => 'select',
        'columns' => 'col-12 col-md-6 q-pr-sm q-pt-sm',
        'props' => [
            'clearable' => true,
            'multiple' => true,
            'label' => 'ilocations::common.settings.availableCountries',
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
    'availableProvinces' => [
        'name' => 'ilocations::availableProvinces',
        'value' => [],
        'type' => 'select',
        'columns' => 'col-12 col-md-6 q-pr-sm q-pt-sm',
        'props' => [
            'clearable' => true,
            'multiple' => true,
            'label' => 'ilocations::common.settings.availableProvinces',
        ],
        'loadOptions' => [
            'apiRoute' => 'apiRoutes.qlocations.provinces', //apiRoute to request
            'select' => ['label' => 'name', 'id' => 'iso2'], //Define fields to config select
            'filterByQuery' => true,
            'requestParams' => [
                'filter' => [
                    'indexAll' => true,
                ],
            ],
        ],
    ],
    'availableCities' => [
        'name' => 'ilocations::availableCities',
        'value' => [],
        'type' => 'select',
        'columns' => 'col-12 col-md-6 q-pr-sm q-pt-sm',
        'props' => [
            'clearable' => true,
            'multiple' => true,
            'label' => 'ilocations::common.settings.availableCities',
        ],
        'loadOptions' => [
            'apiRoute' => 'apiRoutes.qlocations.cities', //apiRoute to request
            'select' => ['label' => 'name', 'id' => 'id'], //Define fields to config select
            'filterByQuery' => true,
            'requestParams' => [
                'filter' => [
                    'indexAll' => true,
                ],
            ],
        ],
    ],
    'countriesToSeedCities' => [
        'value' => ['citiesCO'],
        'name' => 'ilocations::countriesToSeedCities',
        'onlySuperAdmin' => true,
        'type' => 'select',
        'columns' => 'col-6',
        'props' => [
            'label' => 'ilocations::common.settings.countriesToSeedCities',
            'useInput' => false,
            'useChips' => true,
            'multiple' => true,
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'options' => [
                ['label' => 'Colombia', 'value' => 'citiesCO'],
                ['label' => 'United States', 'value' => 'citiesUS'],
                ['label' => 'Mexico', 'value' => 'citiesMX'],
            ],
        ],
    ],
];
