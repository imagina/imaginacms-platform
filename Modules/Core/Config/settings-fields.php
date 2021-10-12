<?php

return [
  'site-name' => [
    'name' => 'core::site-name',
    'value' => 'My Site',
    'type' => 'input',
    'isTranslatable' => true,
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'core::settings.site-name'
    ],
  ],
  'site-name-mini' => [
    'name' => 'core::site-name-mini',
    'value' => null,
    'type' => 'input',
    'isTranslatable' => true,
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'core::settings.site-name-mini'
    ],
  ],
  'locales' => [
    
    'name' => 'core::locales',
    'value' => [],
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'core::settings.locales',
      'multiple' => true,
      'useChips' => true
    ],
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.qsite.siteSettings',
      'select' => ['label' => 'name', 'id' => 'iso'],
      'requestParams' => ['filter' => ['settingGroupName' => 'availableLocales']]
    ]
  ],
  'template' => [
    "onlySuperAdmin" => true,
    'name' => 'core::template',
    'value' => null,
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'core::settings.template'
    ],
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.qsite.siteSettings',
      'select' => ['label' => 'name', 'id' => 'name'],
      'requestParams' => ['filter' => ['settingGroupName' => 'availableThemes']]
    ]
  ],
  'site-description' => [
    'name' => 'core::site-description',
    'value' => null,
    'type' => 'input',
    'isTranslatable' => true,
    'props' => [
      'label' => 'core::settings.site-description',
      'type' => 'textarea',
      'rows' => 3,
    ],
  ],
  'analytics-script' => [
    'name' => 'core::analytics-script',
    'value' => null,
    'type' => 'input',
    'props' => [
      'label' => 'core::settings.analytics-script',
      'type' => 'textarea',
      'rows' => 3,
    ],
  ],
];
