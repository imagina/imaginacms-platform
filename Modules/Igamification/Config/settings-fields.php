<?php

return [
    //Help Center
    'hcStatus' => [
        'onlySuperAdmin' => true,
        'name' => 'igamification::hcStatus',
        'value' => '1',
        'type' => 'select',
        'groupName' => 'helpCenter',
        'groupTitle' => 'igamification::common.settingGroups.helpCenter',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'label' => 'igamification::common.settings.helpCenter.status',
            'options' => [
                ['label' => 'isite::common.yes', 'value' => '1'],
                ['label' => 'isite::common.no', 'value' => '0'],
            ],
        ],
    ],
    'hcInternalCategory' => [
        'onlySuperAdmin' => true,
        'name' => 'igamification::hcInternalCategory',
        'value' => null,
        'type' => 'select',
        'groupName' => 'helpCenter',
        'groupTitle' => 'igamification::common.settingGroups.helpCenter',
        'columns' => 'col-12 col-md-6',
        'help' => [
            'description' => 'igamification::common.settings.helpCenter.internalCategoryDescription',
        ],
        'props' => [
            'label' => 'igamification::common.settings.helpCenter.internalCategory',
            'clearable' => true,
        ],
        'loadOptions' => [
            'apiRoute' => 'apiRoutes.qgamification.categories',
            'select' => ['label' => 'title', 'id' => 'systemName'],
        ],
    ],
    'hcCentralizedSource' => [
        'onlySuperAdmin' => true,
        'name' => 'igamification::hcCentralizedSource',
        'value' => 'https://wygo.com.co',
        'type' => 'input',
        'groupName' => 'helpCenter',
        'groupTitle' => 'igamification::common.settingGroups.helpCenter',
        'columns' => 'col-12',
        'required' => true,
        'help' => [
            'description' => 'igamification::common.settings.helpCenter.centralizedSourceDescription',
        ],
        'props' => [
            'label' => 'igamification::common.settings.helpCenter.centralizedSource',
        ],
    ],
];
