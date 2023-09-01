<?php

return [
    'appVersion' => [
        'onlySuperAdmin' => true,
        'value' => '0.0.1',
        'name' => 'isite::appVersion',
        'type' => 'input',
        'props' => ['label' => 'isite::sites.settings.appVersion'],
    ],

    //Media
    'logo1' => [
        'value' => (object) ['isite::logo1' => null],
        'name' => 'medias_single',
        'fakeFieldName' => 'isite::logo1',
        'type' => 'media',
        'groupName' => 'media',
        'groupTitle' => 'isite::common.settingGroups.media',
        'quickSetting' => true,
        'props' => [
            'label' => 'isite::common.settings.logo1',
            'zone' => 'isite::logo1',
            'entity' => "Modules\Setting\Entities\Setting",
            'entityId' => null,
        ],
    ],
    'logo2' => [
        'value' => (object) ['isite::logo2' => null],
        'name' => 'medias_single',
        'fakeFieldName' => 'isite::logo2',
        'type' => 'media',
        'groupName' => 'media',
        'groupTitle' => 'isite::common.settingGroups.media',
        'props' => [
            'label' => 'isite::common.settings.logo2',
            'zone' => 'isite::logo2',
            'entity' => "Modules\Setting\Entities\Setting",
            'entityId' => null,
        ],
    ],
    'logo3' => [
        'value' => (object) ['isite::logo3' => null],
        'name' => 'medias_single',
        'fakeFieldName' => 'isite::logo3',
        'type' => 'media',
        'groupName' => 'media',
        'groupTitle' => 'isite::common.settingGroups.media',
        'props' => [
            'label' => 'isite::common.settings.logo3',
            'zone' => 'isite::logo3',
            'entity' => "Modules\Setting\Entities\Setting",
            'entityId' => null,
        ],
    ],
    'logoIadmin' => [
        'value' => (object) ['isite::logoIadmin' => null],
        'name' => 'medias_single',
        'fakeFieldName' => 'isite::logoIadmin',
        'type' => 'media',
        'groupName' => 'media',
        'groupTitle' => 'isite::common.settingGroups.media',
        'props' => [
            'label' => 'isite::common.settings.logoIadmin',
            'zone' => 'isite::logoIadmin',
            'entity' => "Modules\Setting\Entities\Setting",
            'entityId' => null,
        ],
    ],
    'logoIadminSM' => [
        'value' => (object) ['isite::logoIadminSM' => null],
        'name' => 'medias_single',
        'fakeFieldName' => 'isite::logoIadminSM',
        'type' => 'media',
        'groupName' => 'media',
        'groupTitle' => 'isite::common.settingGroups.media',
        'props' => [
            'label' => 'isite::common.settings.logoIadminSM',
            'zone' => 'isite::logoIadminSM',
            'entity' => "Modules\Setting\Entities\Setting",
            'entityId' => null,
        ],
    ],
    'favicon' => [
        'value' => (object) ['isite::favicon' => null],
        'name' => 'medias_single',
        'fakeFieldName' => 'isite::favicon',
        'type' => 'media',
        'groupName' => 'media',
        'groupTitle' => 'isite::common.settingGroups.media',
        'props' => [
            'label' => 'isite::common.settings.favicon',
            'zone' => 'isite::favicon',
            'entity' => "Modules\Setting\Entities\Setting",
            'entityId' => null,
        ],
    ],
    //Colors
    'brandPrimary' => [
        'value' => null,
        'name' => 'isite::brandPrimary',
        'type' => 'inputColor',
        'groupName' => 'colors',
        'groupTitle' => 'isite::common.settingGroups.colors',
        'colClass' => 'col-12 col-md-6',
        'quickSetting' => true,
        'props' => [
            'label' => 'isite::common.settings.brandPrimary',
        ],
    ],
    'primaryContrast' => [
        'value' => null,
        'name' => 'isite::primaryContrast',
        'type' => 'inputColor',
        'groupName' => 'colors',
        'groupTitle' => 'isite::common.settingGroups.colors',
        'colClass' => 'col-12 col-md-6',
        'quickSetting' => true,
        'props' => [
            'label' => 'isite::common.settings.primaryContrast',
        ],
    ],
    'brandSecondary' => [
        'value' => null,
        'name' => 'isite::brandSecondary',
        'type' => 'inputColor',
        'groupName' => 'colors',
        'groupTitle' => 'isite::common.settingGroups.colors',
        'colClass' => 'col-12 col-md-6',
        'quickSetting' => true,
        'props' => [
            'label' => 'isite::common.settings.brandSecondary',
        ],
    ],
    'secondaryContrast' => [
        'value' => null,
        'name' => 'isite::secondaryContrast',
        'type' => 'inputColor',
        'groupName' => 'colors',
        'groupTitle' => 'isite::common.settingGroups.colors',
        'colClass' => 'col-12 col-md-6',
        'quickSetting' => true,
        'props' => [
            'label' => 'isite::common.settings.secondaryContrast',
        ],
    ],
    'brandAddressBar' => [
        'value' => null,
        'name' => 'isite::brandAddressBar',
        'type' => 'inputColor',
        'groupName' => 'colors',
        'groupTitle' => 'isite::common.settingGroups.colors',
        'colClass' => 'col-12 col-md-6',
        'props' => [
            'label' => 'isite::common.settings.addressBar',
        ],
    ],
    'brandAccent' => [
        'value' => null,
        'name' => 'isite::brandAccent',
        'type' => 'inputColor',
        'groupName' => 'colors',
        'groupTitle' => 'isite::common.settingGroups.colors',
        'colClass' => 'col-12 col-md-6',
        'props' => [
            'label' => 'isite::common.settings.brandAccent',
        ],
    ],
    'brandPositive' => [
        'value' => null,
        'name' => 'isite::brandPositive',
        'type' => 'inputColor',
        'groupName' => 'colors',
        'groupTitle' => 'isite::common.settingGroups.colors',
        'colClass' => 'col-12 col-md-6',
        'props' => [
            'label' => 'isite::common.settings.brandPositive',
        ],
    ],
    'brandNegative' => [
        'value' => null,
        'name' => 'isite::brandNegative',
        'type' => 'inputColor',
        'groupName' => 'colors',
        'groupTitle' => 'isite::common.settingGroups.colors',
        'colClass' => 'col-12 col-md-6',
        'props' => [
            'label' => 'isite::common.settings.brandNegative',
        ],
    ],
    'brandInfo' => [
        'value' => null,
        'name' => 'isite::brandInfo',
        'type' => 'inputColor',
        'groupName' => 'colors',
        'groupTitle' => 'isite::common.settingGroups.colors',
        'colClass' => 'col-12 col-md-6',
        'props' => [
            'label' => 'isite::common.settings.brandInfo',
        ],
    ],
    'brandWarning' => [
        'value' => null,
        'name' => 'isite::brandWarning',
        'type' => 'inputColor',
        'groupName' => 'colors',
        'groupTitle' => 'isite::common.settingGroups.colors',
        'colClass' => 'col-12 col-md-6',
        'props' => [
            'label' => 'isite::common.settings.brandWarning',
        ],
    ],
    'brandDark' => [
        'value' => null,
        'name' => 'isite::brandDark',
        'type' => 'inputColor',
        'groupName' => 'colors',
        'groupTitle' => 'isite::common.settingGroups.colors',
        'colClass' => 'col-12 col-md-6',
        'props' => [
            'label' => 'isite::common.settings.brandDark',
        ],
    ],
    //Social networks
    'facebook' => [
        'value' => null,
        'name' => 'facebook',
        'fakeFieldName' => 'isite::socialNetworks',
        'type' => 'input',
        'isTranslatable' => true,
        'groupName' => 'socialNetworks',
        'groupTitle' => 'isite::common.settingGroups.socialNetworks',
        'props' => ['label' => 'Facebook'],
    ],
    'twitter' => [
        'value' => null,
        'name' => 'twitter',
        'fakeFieldName' => 'isite::socialNetworks',
        'type' => 'input',
        'isTranslatable' => true,
        'groupName' => 'socialNetworks',
        'groupTitle' => 'isite::common.settingGroups.socialNetworks',
        'props' => ['label' => 'Twitter'],
    ],
    'instagram' => [
        'value' => null,
        'name' => 'instagram',
        'fakeFieldName' => 'isite::socialNetworks',
        'type' => 'input',
        'isTranslatable' => true,
        'groupName' => 'socialNetworks',
        'groupTitle' => 'isite::common.settingGroups.socialNetworks',
        'props' => ['label' => 'Instagram'],
    ],
    'tiktok' => [
        'value' => null,
        'name' => 'tiktok',
        'fakeFieldName' => 'isite::socialNetworks',
        'type' => 'input',
        'isTranslatable' => true,
        'groupName' => 'socialNetworks',
        'groupTitle' => 'isite::common.settingGroups.socialNetworks',
        'props' => ['label' => 'TikTok'],
    ],
    'Linkedin' => [
        'value' => null,
        'name' => 'linkedin',
        'fakeFieldName' => 'isite::socialNetworks',
        'type' => 'input',
        'isTranslatable' => true,
        'groupName' => 'socialNetworks',
        'groupTitle' => 'isite::common.settingGroups.socialNetworks',
        'props' => ['label' => 'Linkedin'],
    ],
    'google' => [
        'value' => null,
        'name' => 'google',
        'fakeFieldName' => 'isite::socialNetworks',
        'type' => 'input',
        'isTranslatable' => true,
        'groupName' => 'socialNetworks',
        'groupTitle' => 'isite::common.settingGroups.socialNetworks',
        'props' => ['label' => 'Google'],
    ],
    'skype' => [
        'value' => null,
        'name' => 'skype',
        'fakeFieldName' => 'isite::socialNetworks',
        'type' => 'input',
        'isTranslatable' => true,
        'groupName' => 'socialNetworks',
        'groupTitle' => 'isite::common.settingGroups.socialNetworks',
        'props' => ['label' => 'Skype'],
    ],
    'telegram' => [
        'value' => null,
        'name' => 'telegram',
        'fakeFieldName' => 'isite::socialNetworks',
        'type' => 'input',
        'isTranslatable' => true,
        'groupName' => 'socialNetworks',
        'groupTitle' => 'isite::common.settingGroups.socialNetworks',
        'props' => ['label' => 'Telegram'],
    ],
    'youtube' => [
        'value' => null,
        'name' => 'youtube',
        'fakeFieldName' => 'isite::socialNetworks',
        'groupName' => 'socialNetworks',
        'groupTitle' => 'isite::common.settingGroups.socialNetworks',
        'type' => 'input',
        'isTranslatable' => true,
        'group' => 'isite::common.settingGroups.socialNetworks',
        'props' => ['label' => 'YouTube'],
    ],
    'flickr' => [
        'value' => null,
        'name' => 'flickr',
        'fakeFieldName' => 'isite::socialNetworks',
        'type' => 'input',
        'isTranslatable' => true,
        'groupName' => 'socialNetworks',
        'groupTitle' => 'isite::common.settingGroups.socialNetworks',
        'props' => ['label' => 'Flickr'],
    ],
    'pinterest' => [
        'value' => null,
        'name' => 'pinterest',
        'fakeFieldName' => 'isite::socialNetworks',
        'type' => 'input',
        'isTranslatable' => true,
        'groupName' => 'socialNetworks',
        'groupTitle' => 'isite::common.settingGroups.socialNetworks',
        'props' => ['label' => 'Pinterest'],
    ],
    'whatsapp1' => [
        'name' => 'isite::whatsapp1',
        'label' => 'Whatsapp #1',
        'isTranslatable' => true,
        'groupName' => 'socialNetworks',
        'groupTitle' => 'isite::common.settingGroups.socialNetworks',
        'multiple' => true,
        'children' => [
            'callingCode' => [
                'name' => 'callingCode',
                'value' => null,
                'type' => 'select',
                'colClass' => 'col-6 col-xl-2 q-pr-sm q-pt-sm',
                'props' => [
                    'label' => 'isite::common.settings.whatsapp.callingCode',
                ],
                'loadOptions' => [
                    'apiRoute' => 'apiRoutes.qlocations.countries', //apiRoute to request
                    'select' => ['label' => 'name', 'id' => 'callingCode'], //Define fields to config select
                ],
            ],
            'number' => [
                'name' => 'number',
                'value' => null,
                'type' => 'input',
                'colClass' => 'col-6 col-xl-2 q-pr-sm q-pt-sm',
                'props' => [
                    'label' => 'isite::common.settings.whatsapp.number',
                    'type' => 'number',
                ],
            ],
            'message' => [
                'name' => 'message',
                'value' => null,
                'type' => 'input',
                'colClass' => 'col-12 col-xl-3 q-pr-sm q-pt-sm',
                'props' => [
                    'label' => 'isite::common.settings.whatsapp.message',
                ],
            ],
            'label' => [
                'name' => 'label',
                'value' => null,
                'type' => 'input',
                'colClass' => 'col-6 col-xl-3 q-pr-sm q-pt-sm',
                'props' => [
                    'label' => 'isite::common.settings.whatsapp.label',
                ],
            ],
            'iconLabel' => [
                'name' => 'iconLabel',
                'value' => null,
                'type' => 'input',
                'colClass' => 'col-6 col-xl-2 q-pr-sm q-pt-sm',
                'props' => [
                    'label' => 'isite::common.settings.whatsapp.icon-label',
                ],
            ],
        ],
    ],
    'whatsapp2' => [
        'name' => 'isite::whatsapp2',
        'label' => 'Whatsapp #2',
        'isTranslatable' => true,
        'groupName' => 'socialNetworks',
        'groupTitle' => 'isite::common.settingGroups.socialNetworks',
        'multiple' => true,
        'children' => [
            'callingCode' => [
                'name' => 'callingCode',
                'value' => null,
                'type' => 'select',
                'colClass' => 'col-6 col-xl-2 q-pr-sm q-pt-sm',
                'props' => [
                    'label' => 'isite::common.settings.whatsapp.callingCode',
                ],
                'loadOptions' => [
                    'apiRoute' => 'apiRoutes.qlocations.countries', //apiRoute to request
                    'select' => ['label' => 'name', 'id' => 'callingCode'], //Define fields to config select
                ],
            ],
            'number' => [
                'name' => 'number',
                'value' => null,
                'type' => 'input',
                'colClass' => 'col-6 col-xl-2 q-pr-sm q-pt-sm',
                'props' => [
                    'label' => 'isite::common.settings.whatsapp.number',
                    'type' => 'number',
                ],
            ],
            'message' => [
                'name' => 'message',
                'value' => null,
                'type' => 'input',
                'colClass' => 'col-12 col-xl-3 q-pr-sm q-pt-sm',
                'props' => [
                    'label' => 'isite::common.settings.whatsapp.message',
                ],
            ],
            'label' => [
                'name' => 'label',
                'value' => null,
                'type' => 'input',
                'colClass' => 'col-6 col-xl-3 q-pr-sm q-pt-sm',
                'props' => [
                    'label' => 'isite::common.settings.whatsapp.label',
                ],
            ],
            'iconLabel' => [
                'name' => 'iconLabel',
                'value' => null,
                'type' => 'input',
                'colClass' => 'col-6 col-xl-2 q-pr-sm q-pt-sm',
                'props' => [
                    'label' => 'isite::common.settings.whatsapp.icon-label',
                ],
            ],
        ],
    ],
    'whatsapp3' => [
        'name' => 'isite::whatsapp3',
        'label' => 'Whatsapp #3',
        'isTranslatable' => true,
        'groupName' => 'socialNetworks',
        'groupTitle' => 'isite::common.settingGroups.socialNetworks',
        'children' => [
            'callingCode' => [
                'name' => 'callingCode',
                'value' => null,
                'type' => 'select',
                'colClass' => 'col-6 col-xl-2 q-pr-sm q-pt-sm',
                'props' => [
                    'label' => 'isite::common.settings.whatsapp.callingCode',
                ],
                'loadOptions' => [
                    'apiRoute' => 'apiRoutes.qlocations.countries', //apiRoute to request
                    'select' => ['label' => 'name', 'id' => 'callingCode'], //Define fields to config select
                ],
            ],
            'number' => [
                'name' => 'number',
                'value' => null,
                'type' => 'input',
                'colClass' => 'col-6 col-xl-2 q-pr-sm q-pt-sm',
                'props' => [
                    'label' => 'isite::common.settings.whatsapp.number',
                    'type' => 'number',
                ],
            ],
            'message' => [
                'name' => 'message',
                'value' => null,
                'type' => 'input',
                'colClass' => 'col-12 col-xl-3 q-pr-sm q-pt-sm',
                'props' => [
                    'label' => 'isite::common.settings.whatsapp.message',
                ],
            ],
            'label' => [
                'name' => 'label',
                'value' => null,
                'type' => 'input',
                'colClass' => 'col-6 col-xl-3 q-pr-sm q-pt-sm',
                'props' => [
                    'label' => 'isite::common.settings.whatsapp.label',
                ],
            ],
            'iconLabel' => [
                'name' => 'iconLabel',
                'value' => null,
                'type' => 'input',
                'colClass' => 'col-6 col-xl-2 q-pr-sm q-pt-sm',
                'props' => [
                    'label' => 'isite::common.settings.whatsapp.icon-label',
                ],
            ],
        ],
    ],
    //Recaptcha
    'activateCaptcha' => [
        'value' => '0',
        'name' => 'isite::activateCaptcha',
        'type' => 'checkbox',
        'groupName' => 'apiKeys',
        'groupTitle' => 'isite::common.settingGroups.apiKeys',
        'props' => [
            'label' => 'isite::common.settings.activateCaptcha',
            'trueValue' => '1',
            'falseValue' => '0',
        ],
    ],
    'reCaptchaV2Secret' => [
        'value' => null,
        'name' => 'isite::reCaptchaV2Secret',
        'type' => 'input',
        'groupName' => 'apiKeys',
        'groupTitle' => 'isite::common.settingGroups.apiKeys',
        'props' => [
            'label' => 'isite::common.settings.reCaptchaV2Secret',
        ],
    ],
    'reCaptchaV2Site' => [
        'value' => null,
        'name' => 'isite::reCaptchaV2Site',
        'type' => 'input',
        'groupName' => 'apiKeys',
        'groupTitle' => 'isite::common.settingGroups.apiKeys',
        'props' => [
            'label' => 'isite::common.settings.reCaptchaV2Site',
        ],
    ],
    'reCaptchaV3Secret' => [
        'value' => null,
        'name' => 'isite::reCaptchaV3Secret',
        'type' => 'input',
        'groupName' => 'apiKeys',
        'groupTitle' => 'isite::common.settingGroups.apiKeys',
        'props' => [
            'label' => 'isite::common.settings.reCaptchaV3Secret',
        ],
    ],
    'reCaptchaV3Site' => [
        'value' => null,
        'name' => 'isite::reCaptchaV3Site',
        'type' => 'input',
        'groupName' => 'apiKeys',
        'groupTitle' => 'isite::common.settingGroups.apiKeys',
        'props' => [
            'label' => 'isite::common.settings.reCaptchaV3Site',
        ],
    ],
    //Google
    'api-maps' => [
        'value' => null,
        'name' => 'isite::api-maps',
        'type' => 'input',
        'groupName' => 'apiKeys',
        'groupTitle' => 'isite::common.settingGroups.apiKeys',
        'props' => [
            'label' => 'isite::common.settings.apimaps',
        ],
    ],
    //Open street maps
    'api-open-street-maps' => [
        'value' => null,
        'name' => 'isite::api-open-street-maps',
        'type' => 'input',
        'groupName' => 'apiKeys',
        'groupTitle' => 'isite::common.settingGroups.apiKeys',
        'props' => [
            'label' => 'isite::common.settings.apiOpenStreetMaps',
        ],
    ],
    //Multiples
    'phones' => [
        'value' => [],
        'name' => 'isite::phones',
        'type' => 'select',
        'groupName' => 'contact',
        'groupTitle' => 'isite::common.settingGroups.contact',
        'quickSetting' => true,
        'props' => [
            'label' => 'isite::common.settings.phones',
            'useInput' => true,
            'useChips' => true,
            'multiple' => true,
            'hideDropdownIcon' => true,
            'hint' => 'isite::common.settingHints.phones',
            'newValueMode' => 'add-unique',
        ],
    ],
    'addresses' => [
        'value' => [],
        'name' => 'isite::addresses',
        'type' => 'select',
        'groupName' => 'contact',
        'groupTitle' => 'isite::common.settingGroups.contact',
        'quickSetting' => true,
        'props' => [
            'label' => 'isite::common.settings.addresses',
            'useInput' => true,
            'useChips' => true,
            'multiple' => true,
            'hideDropdownIcon' => true,
            'hint' => 'isite::common.settingHints.addresses',
            'newValueMode' => 'add-unique',
        ],
    ],
    'emails' => [
        'value' => [],
        'name' => 'isite::emails',
        'type' => 'select',
        'groupName' => 'contact',
        'groupTitle' => 'isite::common.settingGroups.contact',
        'props' => [
            'label' => 'isite::common.settings.emails',
            'useInput' => true,
            'useChips' => true,
            'multiple' => true,
            'hideDropdownIcon' => true,
            'hint' => 'isite::common.settingHints.emails',
            'newValueMode' => 'add-unique',
        ],
    ],
    //Custom
    'headerCustomJs' => [
        'value' => null,
        'name' => 'isite::headerCustomJs',
        'type' => 'input',
        'groupName' => 'customSources',
        'groupTitle' => 'isite::common.settingGroups.customSources',
        'colClass' => 'col-12 col-md-12',
        'props' => [
            'label' => 'isite::common.settings.headerCustomJs',
            'type' => 'textarea',
            'rows' => 12,
        ],
    ],
    'customCss' => [
        'value' => null,
        'name' => 'isite::customCss',
        'type' => 'input',
        'groupName' => 'customSources',
        'groupTitle' => 'isite::common.settingGroups.customSources',
        'colClass' => 'col-12 col-md-12',
        'props' => [
            'label' => 'isite::common.settings.customCss',
            'type' => 'textarea',
            'rows' => 12,
        ],
    ],
    'customJs' => [
        'value' => null,
        'name' => 'isite::customJs',
        'type' => 'input',
        'groupName' => 'customSources',
        'groupTitle' => 'isite::common.settingGroups.customSources',
        'colClass' => 'col-12 col-md-12',
        'props' => [
            'label' => 'isite::common.settings.customJs',
            'type' => 'textarea',
            'rows' => 12,
        ],
    ],

    //Client Google
    'api-client-google' => [
        'value' => '',
        'name' => 'isite::googleClientId',
        'type' => 'input',
        'groupName' => 'apiKeys',
        'groupTitle' => 'isite::common.settingGroups.apiKeys',
        'props' => [
            'label' => 'isite::common.settings.googleClient',
        ],
    ],
    //Client Facebook
    'api-client-facebook' => [
        'value' => '',
        'name' => 'isite::facebookClientId',
        'type' => 'input',
        'groupName' => 'apiKeys',
        'groupTitle' => 'isite::common.settingGroups.apiKeys',
        'props' => [
            'label' => 'isite::common.settings.facebookClient',
        ],
    ],
    //Facebook APP ID
    'facebookAppId' => [
        'value' => '',
        'name' => 'isite::facebookAppId',
        'type' => 'input',
        'groupName' => 'apiKeys',
        'groupTitle' => 'isite::common.settingGroups.apiKeys',
        'props' => [
            'label' => 'isite::common.settings.facebookAppId',
        ],
    ],
    //Choose pdf header logo
    'pdfLogoHeader' => [
        'value' => 'logo1',
        'name' => 'isite::pdfLogoHeader',
        'groupName' => 'pdf',
        'groupTitle' => 'isite::pdf.settings.pdf.group',
        'type' => 'select',
        'colClass' => 'col-6',
        'props' => [
            'label' => 'isite::pdf.settings.pdf.text.Logo_header',
            'useInput' => false,
            'useChips' => false,
            'multiple' => false,
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'options' => [
                ['label' => 'Logotipo 1', 'value' => 'logo1'],
                ['label' => 'Logotipo 2', 'value' => 'logo2'],
                ['label' => 'logotipo 3', 'value' => 'logo3'],
            ],
        ],
    ],
    //Customize pdf header
    'pdfPreContent' => [
        'value' => null,
        'name' => 'isite::pdfPreContent',
        'groupName' => 'pdf',
        'groupTitle' => 'isite::pdf.settings.pdf.group',
        'type' => 'html',
        'props' => [
            'label' => 'isite::pdf.settings.pdf.text.Information_header',
        ],
    ],
    //Customize pdf footer
    'pdfFooterContent' => [
        'value' => null,
        'name' => 'isite::pdfFooterContent',
        'groupName' => 'pdf',
        'groupTitle' => 'isite::pdf.settings.pdf.group',
        'type' => 'html',
        'props' => [
            'label' => 'isite::pdf.settings.pdf.text.Information_footer',
        ],
    ],
    //Customize section product information pdf
    'pdfPostContent' => [
        'value' => null,
        'name' => 'isite::pdfPostContent',
        'groupName' => 'pdf',
        'groupTitle' => 'isite::pdf.settings.pdf.group',
        'type' => 'html',
        'props' => [
            'label' => 'isite::pdf.settings.pdf.text.Information_content',
        ],
    ],

    //Roles to register
    'rolesToTenant' => [
        'onlySuperAdmin' => true,
        'name' => 'isite::rolesToTenant',
        'value' => [],
        'type' => 'select',
        'groupName' => 'tenants',
        'groupTitle' => 'isite::common.settingGroups.tenants',
        'props' => [
            'label' => 'isite::common.settings.rolesToTenant',
            'multiple' => true,
            'useChips' => true,
        ],
        'loadOptions' => [
            'apiRoute' => 'apiRoutes.quser.roles',
            'select' => ['label' => 'name', 'id' => 'id'],
        ],
    ],

    //Default Tenant Status
    'defaultTenantStatus' => [
        'value' => true,
        'name' => 'isite::defaultTenantStatus',
        'type' => 'select',
        'groupName' => 'tenants',
        'groupTitle' => 'isite::common.settingGroups.tenants',
        'colClass' => 'col-6',
        'props' => [
            'label' => 'isite::common.settings.tenant.defaultTenantStatus',
            'useInput' => false,
            'useChips' => false,
            'multiple' => false,
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'options' => [
                ['label' => 'Activo', 'value' => true],
                ['label' => 'Inactivo', 'value' => false],
            ],
        ],
    ],

    //Tenant route alias
    'tenantRouteAlias' => [
        'value' => 'homepage',
        'name' => 'isite::tenantRouteAlias',
        'onlySuperAdmin' => true,
        'type' => 'input',
        'groupName' => 'tenants',
        'groupTitle' => 'isite::common.settingGroups.tenants',
        'props' => [
            'label' => 'isite::common.settings.tenantRouteAlias',
        ],
    ],
    'wizardTenantType' => [
        'onlySuperAdmin' => true,
        'name' => 'isite::wizardTenantType',
        'value' => 'local',
        'type' => 'select',
        'groupName' => 'tenants',
        'groupTitle' => 'isite::common.settingGroups.tenants',
        'props' => [
            'label' => 'isite::common.settings.wizardTenantType',
            'options' => [
                ['label' => 'Weygo', 'value' => 'weygo'],
                ['label' => 'Local', 'value' => 'local'],
            ],
        ],
    ],

    'mapInShow' => [
        'onlySuperAdmin' => true,
        'value' => 'openStreet',
        'name' => 'isite::mapInShow',
        'type' => 'select',
        'groupName' => 'maps',
        'groupTitle' => 'isite::common.maps.groupMaps',
        'props' => [
            'label' => 'isite::common.maps.mapsLabel',
            'options' => [
                ['label' => 'OpenStreet', 'value' => 'openStreet'],
                ['label' => 'GoogleMaps', 'value' => 'googleMaps'],
            ],
        ],
    ],

    'statusModalVerifier' => [
        'value' => '0',
        'name' => 'isite::statusModalVerifier',
        'type' => 'checkbox',
        'groupName' => 'modalVerifier',
        'groupTitle' => 'isite::common.settingGroups.modalVerifier',
        'props' => [
            'trueValue' => '1',
            'falseValue' => '0',
            'label' => 'isite::isite.verifier.active',
        ],
    ],
    'titleModalVerifier' => [
        'value' => '',
        'name' => 'isite::titleModalVerifier',
        'type' => 'input',
        'colClass' => 'col-12',
        'groupName' => 'modalVerifier',
        'groupTitle' => 'isite::common.settingGroups.modalVerifier',
        'props' => [
            'label' => 'isite::isite.verifier.title',
        ],
    ],
    'contentModalVerifier' => [
        'value' => '',
        'name' => 'isite::contentModalVerifier',
        'type' => 'html',
        'colClass' => 'col-12',
        'groupName' => 'modalVerifier',
        'groupTitle' => 'isite::common.settingGroups.modalVerifier',
        'props' => [
            'label' => 'isite::isite.verifier.content',
        ],
    ],
    'buttonLabelModalVerifier' => [
        'value' => '',
        'name' => 'isite::buttonLabelModalVerifier',
        'type' => 'input',
        'colClass' => 'col-12',
        'groupName' => 'modalVerifier',
        'groupTitle' => 'isite::common.settingGroups.modalVerifier',
        'props' => [
            'label' => 'isite::isite.verifier.buttonLabel',
        ],
    ],
    //Choose header layout
    'headerLayout' => [
        'value' => 'header-layout-1',
        'name' => 'isite::headerLayout',
        'onlySuperAdmin' => true,
        'type' => 'select',
        'colClass' => 'col-6',
        'props' => [
            'label' => 'isite::common.settings.headerLayout',
            'useInput' => false,
            'useChips' => false,
            'multiple' => false,
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'options' => [
                ['label' => 'Header Layout 1', 'value' => 'header-layout-1'],
                ['label' => 'Header Layout 2', 'value' => 'header-layout-2'],
                ['label' => 'Header Layout 3', 'value' => 'header-layout-3'],
            ],
        ],
    ], //Choose footer layout
    'footerLayout' => [
        'value' => 'footer-layout-1',
        'name' => 'isite::footerLayout',
        'onlySuperAdmin' => true,
        'type' => 'select',
        'colClass' => 'col-6',
        'props' => [
            'label' => 'isite::common.settings.footerLayout',
            'useInput' => false,
            'useChips' => false,
            'multiple' => false,
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'options' => [
                ['label' => 'Footer Layout 1', 'value' => 'footer-layout-1'],
                ['label' => 'Footer Layout 2', 'value' => 'footer-layout-2'],
                ['label' => 'Footer Layout 3', 'value' => 'footer-layout-3'],
            ],
        ],
    ],
    //Components
    'itemsTabs' => [
        'value' => ['Item-1', 'Item-2'],
        'name' => 'isite::itemsTabs',
        'type' => 'select',
        'groupName' => 'components',
        'groupTitle' => 'isite::common.settingGroups.components',
        'props' => [
            'label' => 'isite::common.settings.itemsTabs',
            'useInput' => true,
            'useChips' => true,
            'multiple' => true,
            'hideDropdownIcon' => true,
            'hint' => 'isite::common.settingHints.itemsTabs',
            'newValueMode' => 'add-unique',
        ],
    ],
    'locationName' => [
        'name' => 'isite::locationName',
        'value' => null,
        'type' => 'input',
        'groupName' => 'maps',
        'groupTitle' => 'isite::common.maps.groupMaps',
        'props' => [
            'label' => 'isite::common.maps.labelLocationName',
        ],
    ],
    'locationSite' => [
        'value' => '{"title" : "Ubicación", "lat" : 4.646920449476433, "lng" : -74.07857977257274}',
        'name' => 'isite::locationSite',
        'type' => 'positionMarkerMap',
        'colClass' => 'col-12',
        'groupName' => 'maps',
        'groupTitle' => 'isite::common.maps.groupMaps',
        'props' => [
            'label' => 'isite::common.maps.labelLocationSite',
        ],
    ],
    'tenantWithCentralData' => [
        'value' => [],
        'name' => 'isite::tenantWithCentralData',
        'groupName' => 'tenants',
        'groupTitle' => 'isite::common.settings.tenant.group',
        'onlySuperAdmin' => true,
        'type' => 'select',
        'columns' => 'col-6',
        'props' => [
            'label' => 'isite::common.settings.tenant.tenantWithCentralData',
            'useInput' => false,
            'useChips' => true,
            'multiple' => true,
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'options' => [
                ['label' => 'isite::common.settings.tenant.entities.setting', 'value' => 'setting'],
                ['label' => 'isite::common.settings.tenant.entities.page', 'value' => 'page'],
                ['label' => 'isite::common.settings.tenant.entities.slider', 'value' => 'slider'],
                ['label' => 'isite::common.settings.tenant.entities.slide', 'value' => 'slide'],
                ['label' => 'isite::common.settings.tenant.entities.menu', 'value' => 'menu'],
                ['label' => 'isite::common.settings.tenant.entities.menuitem', 'value' => 'menuitem'],
            ],
        ],
    ],
    //CMS
    'legacyStructureCMS' => [
        'name' => 'isite::legacyStructureCMS',
        'value' => '0',
        'type' => 'select',
        'groupName' => 'cms',
        'groupTitle' => 'isite::common.settingGroups.cms',
        'props' => [
            'label' => 'isite::common.settings.cms.legacyStructureCMS',
            'options' => [
                ['label' => 'isite::common.yes', 'value' => '1'],
                ['label' => 'isite::common.no', 'value' => '0'],
            ],
        ],
    ],
    'iadminTheme' => [
        'name' => 'isite::iadminTheme',
        'value' => '1',
        'type' => 'select',
        'groupName' => 'cms',
        'groupTitle' => 'isite::common.settingGroups.cms',
        'props' => [
            'label' => 'isite::common.settings.cms.iadminTheme.title',
            'options' => [
                ['label' => 'isite::common.settings.cms.iadminTheme.theme1', 'value' => '1'],
                ['label' => 'isite::common.settings.cms.iadminTheme.theme2', 'value' => '2'],
            ],
        ],
    ],
    'sitemapDepth' => [
        'value' => 5,
        'name' => 'isite::sitemapDepth',
        'type' => 'input',
        'colClass' => 'col-12',
        'groupName' => 'sitemap',
        'groupTitle' => 'isite::common.settingGroups.sitemap',
        'props' => [
            'label' => 'isite::common.sitemap.labelSitemapDepth',
        ],
    ],
    'showGoToSiteButton' => [
        'name' => 'isite::showGoToSiteButton',
        'value' => '1',
        'type' => 'select',
        'groupName' => 'cms',
        'groupTitle' => 'isite::common.settingGroups.cms',
        'props' => [
            'label' => 'isite::common.settings.cms.showGoToSiteButton',
            'options' => [
                ['label' => 'isite::common.yes', 'value' => '1'],
                ['label' => 'isite::common.no', 'value' => '0'],
            ],
        ],
    ],
    'userAgentRobots' => [
        'value' => '*',
        'name' => 'isite::userAgentRobots',
        'type' => 'input',
        'colClass' => 'col-12',
        'groupName' => 'sitemap',
        'groupTitle' => 'isite::common.settingGroups.sitemap',
        'props' => [
            'label' => 'isite::common.sitemap.labelUserAgentRobots',
        ],
    ],
    'activeGenerateRobotsFile' => [
        'value' => '0',
        'name' => 'isite::activeGenerateRobotsFile',
        'type' => 'checkbox',
        'groupName' => 'sitemap',
        'groupTitle' => 'isite::common.settingGroups.sitemap',
        'props' => [
            'label' => 'isite::common.sitemap.labelActiveGenerateRobotsFile',
            'trueValue' => '1',
            'falseValue' => '0',
        ],
    ],
    'enableDynamicFieldsCache' => [
        'value' => '0',
        'name' => 'isite::enableDynamicFieldsCache',
        'onlySuperAdmin' => true,
        'type' => 'checkbox',
        'props' => [
            'label' => 'isite::common.settings.enableDynamicFieldsCache',
            'trueValue' => '1',
            'falseValue' => '0',
        ],
    ],
    'defaultLayout' => [
        'value' => null,
        'name' => 'isite::defaultLayout',
        'onlySuperAdmin' => true,
        'type' => 'select',
        'colClass' => 'col-6',
        'props' => [
            'label' => 'isite::common.settings.defaultLayout',
            'hint' => 'isite::common.settingHints.defaultLayout',
            'useInput' => false,
            'useChips' => false,
            'multiple' => false,
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'options' => [
                ['label' => 'Layout Tienda 1', 'value' => 1],
            ],
            // OJO falta que monten el crud en Frontend
            /*
      'loadOptions' => [
          'apiRoute' => 'apiRoutes.qsite.layouts', //apiRoute to request
          'select' => ['label' => 'title', 'id' => 'id'], //Define fields to config select
      ]
      */
        ],
    ],
    //Microsoft APP ID
    'microsoftClientId' => [
        'value' => '',
        'name' => 'isite::microsoftClientId',
        'type' => 'input',
        'groupName' => 'apiKeys',
        'groupTitle' => 'isite::common.settingGroups.apiKeys',
        'props' => [
            'label' => 'isite::common.settings.microsoftClientId',
        ],
    ],
    'timeExpiredToken' => [
        'value' => 1,
        'name' => 'isite::timeExpiredToken',
        'type' => 'input',
        'groupName' => 'tokens',
        'groupTitle' => 'isite::common.settingGroups.groupNameTimeToken',
        'props' => [
            'label' => 'isite::common.settings.labelTimeExpiredToken',
        ],
    ],
    //N8N
    'n8nUrl' => [
        'onlySuperAdmin' => true,
        'name' => 'isite::n8nUrl',
        'value' => 'https://nflow.imaginacolombia.com',
        'type' => 'input',
        'groupName' => 'N8N',
        'groupTitle' => 'N8N',
        'columns' => 'col-12 col-md-6',
        'help' => [
            'description' => 'URL for N8N node, it will be used for send action through this platform',
        ],
        'props' => [
            'label' => 'N8N Url',
        ],
    ],
    'offline' => [
        'name' => 'isite::offline',
        'value' => '0',
        'type' => 'select',
        'groupName' => 'cms',
        'groupTitle' => 'isite::common.settingGroups.cms',
        'props' => [
            'label' => 'isite::common.settings.cms.offline',
            'options' => [
                ['label' => 'isite::common.yes', 'value' => '1'],
                ['label' => 'isite::common.no', 'value' => '0'],
            ],
        ],
    ],
    'usersToNotify' => [
        'name' => 'isite::usersToNotify',
        'value' => [],
        'type' => 'select',
        'onlySuperAdmin' => true,
        'columns' => 'col-12 col-md-6',
        'groupName' => 'notificationsChanges',
        'groupTitle' => 'isite::common.settings.groupNameNotifyChanges',
        'loadOptions' => [
            'apiRoute' => 'apiRoutes.quser.users',
            'select' => ['label' => 'email', 'id' => 'id'],
        ],
        'props' => [
            'label' => 'isite::common.settings.usersToNotify',
            'multiple' => true,
            'clearable' => true,
        ],
    ],
    'emailsToNotify' => [
        'name' => 'isite::emailsToNotify',
        'value' => [],
        'type' => 'select',
        'onlySuperAdmin' => true,
        'groupName' => 'notificationsChanges',
        'groupTitle' => 'isite::common.settings.groupNameNotifyChanges',
        'props' => [
            'useInput' => true,
            'useChips' => true,
            'multiple' => true,
            'hint' => 'iforms::common.settingHints.emails',
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'label' => 'isite::common.settings.emailsToNotify',
        ],
    ],
    //Centralize brand
    'centralizedBrand' => [
        'value' => null,
        'name' => 'isite::centralizedBrand',
        'type' => 'input',
        'onlySuperAdmin' => true,
        'props' => [
            'label' => 'isite::isite.centralizedBrand',
        ],
    ],
];
