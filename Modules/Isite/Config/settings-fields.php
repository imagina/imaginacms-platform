<?php

return [
  //Media
  'logo1' => [
    'value' => (object)['isite::logo1' => null],
    'name' => 'medias_single',
    'fakeFieldName' => 'isite::logo1',
    'type' => 'media',
    'group' => 'isite::common.settingGroups.media',
    'props' => [
      'label' => 'isite::common.settings.logo1',
      'zone' => 'isite::logo1',
      'entity' => "Modules\Setting\Entities\Setting",
      'entityId' => null
    ]
  ],
  'logo2' => [
    'value' => (object)['isite::logo2' => null],
    'name' => 'medias_single',
    'fakeFieldName' => 'isite::logo2',
    'type' => 'media',
    'group' => 'isite::common.settingGroups.media',
    'props' => [
      'label' => 'isite::common.settings.logo2',
      'zone' => 'isite::logo2',
      'entity' => "Modules\Setting\Entities\Setting",
      'entityId' => null
    ]
  ],
  'logo3' => [
    'value' => (object)['isite::logo3' => null],
    'name' => 'medias_single',
    'fakeFieldName' => 'isite::logo3',
    'type' => 'media',
    'group' => 'isite::common.settingGroups.media',
    'props' => [
      'label' => 'isite::common.settings.logo3',
      'zone' => 'isite::logo3',
      'entity' => "Modules\Setting\Entities\Setting",
      'entityId' => null
    ]
  ],
  'favicon' => [
    'value' => (object)['isite::favicon' => null],
    'name' => 'medias_single',
    'fakeFieldName' => 'isite::favicon',
    'type' => 'media',
    'group' => 'isite::common.settingGroups.media',
    'props' => [
      'label' => 'isite::common.settings.favicon',
      'zone' => 'isite::favicon',
      'entity' => "Modules\Setting\Entities\Setting",
      'entityId' => null
    ]
  ],
  //Colors
  'brandAddressBar' => [
    'value' => null,
    'name' => 'isite::brandAddressBar',
    'type' => 'inputColor',
    'group' => 'isite::common.settingGroups.colors',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'isite::common.settings.addressBar'
    ]
  ],
  'brandPrimary' => [
    'value' => null,
    'name' => 'isite::brandPrimary',
    'type' => 'inputColor',
    'group' => 'isite::common.settingGroups.colors',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'isite::common.settings.brandPrimary'
    ]
  ],
  'brandSecondary' => [
    'value' => null,
    'name' => 'isite::brandSecondary',
    'type' => 'inputColor',
    'group' => 'isite::common.settingGroups.colors',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'isite::common.settings.brandSecondary'
    ]
  ],
  'brandAccent' => [
    'value' => null,
    'name' => 'isite::brandAccent',
    'type' => 'inputColor',
    'group' => 'isite::common.settingGroups.colors',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'isite::common.settings.brandAccent'
    ]
  ],
  'brandPositive' => [
    'value' => null,
    'name' => 'isite::brandPositive',
    'type' => 'inputColor',
    'group' => 'isite::common.settingGroups.colors',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'isite::common.settings.brandPositive'
    ]
  ],
  'brandNegative' => [
    'value' => null,
    'name' => 'isite::brandNegative',
    'type' => 'inputColor',
    'group' => 'isite::common.settingGroups.colors',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'isite::common.settings.brandNegative'
    ]
  ],
  'brandInfo' => [
    'value' => null,
    'name' => 'isite::brandInfo',
    'type' => 'inputColor',
    'group' => 'isite::common.settingGroups.colors',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'isite::common.settings.brandInfo'
    ]
  ],
  'brandWarning' => [
    'value' => null,
    'name' => 'isite::brandWarning',
    'type' => 'inputColor',
    'group' => 'isite::common.settingGroups.colors',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'isite::common.settings.brandWarning'
    ]
  ],
  'brandDark' => [
    'value' => null,
    'name' => 'isite::brandDark',
    'type' => 'inputColor',
    'group' => 'isite::common.settingGroups.colors',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'isite::common.settings.brandDark'
    ]
  ],
  //Social networks
  'facebook' => [
    'value' => null,
    'name' => 'facebook',
    'fakeFieldName' => 'isite::socialNetworks',
    'type' => 'input',
    'group' => 'isite::common.settingGroups.socialNetworks',
    'props' => ['label' => 'Facebook']
  ],
  'twitter' => [
    'value' => null,
    'name' => 'twitter',
    'fakeFieldName' => 'isite::socialNetworks',
    'type' => 'input',
    'group' => 'isite::common.settingGroups.socialNetworks',
    'props' => ['label' => 'Twitter']
  ],
  'instagram' => [
    'value' => null,
    'name' => 'instagram',
    'fakeFieldName' => 'isite::socialNetworks',
    'type' => 'input',
    'group' => 'isite::common.settingGroups.socialNetworks',
    'props' => ['label' => 'Instagram']
  ],
  'Linkedin' => [
    'value' => null,
    'name' => 'linkedin',
    'fakeFieldName' => 'isite::socialNetworks',
    'type' => 'input',
    'group' => 'isite::common.settingGroups.socialNetworks',
    'props' => ['label' => 'Linkedin']
  ],
  'google' => [
    'value' => null,
    'name' => 'google',
    'fakeFieldName' => 'isite::socialNetworks',
    'type' => 'input',
    'group' => 'isite::common.settingGroups.socialNetworks',
    'props' => ['label' => 'Google']
  ],
  'skype' => [
    'value' => null,
    'name' => 'skype',
    'fakeFieldName' => 'isite::socialNetworks',
    'type' => 'input',
    'group' => 'isite::common.settingGroups.socialNetworks',
    'props' => ['label' => 'Skype']
  ],
  //Recaptcha
  'activateCaptcha' => [
    'value' => false,
    'name' => 'isite::activateCaptcha',
    'type' => 'checkbox',
    'group' => 'isite::common.settingGroups.apiKeys',
    'props' => [
      'label' => 'isite::common.settings.activateCaptcha'
    ]
  ],
  'reCaptchaV2Secret' => [
    'value' => false,
    'name' => 'isite::reCaptchaV2Secret',
    'type' => 'input',
    'group' => 'isite::common.settingGroups.apiKeys',
    'props' => [
      'label' => 'isite::common.settings.reCaptchaV2Secret'
    ]
  ],
  'reCaptchaV2Site' => [
    'value' => false,
    'name' => 'isite::reCaptchaV2Site',
    'type' => 'input',
    'group' => 'isite::common.settingGroups.apiKeys',
    'props' => [
      'label' => 'isite::common.settings.reCaptchaV2Site'
    ]
  ],
  'reCaptchaV3Secret' => [
    'value' => false,
    'name' => 'isite::reCaptchaV3Secret',
    'type' => 'input',
    'group' => 'isite::common.settingGroups.apiKeys',
    'props' => [
      'label' => 'isite::common.settings.reCaptchaV3Secret'
    ]
  ],
  'reCaptchaV3Site' => [
    'value' => false,
    'name' => 'isite::reCaptchaV3Site',
    'type' => 'input',
    'group' => 'isite::common.settingGroups.apiKeys',
    'props' => [
      'label' => 'isite::common.settings.reCaptchaV3Site'
    ]
  ],
  //Google
  'api-maps' => [
    'value' => false,
    'name' => 'isite::api-maps',
    'type' => 'input',
    'group' => 'isite::common.settingGroups.apiKeys',
    'props' => [
      'label' => 'isite::common.settings.apimaps'
    ]
  ],
  //Multiples
  'phones' => [
    'value' => [],
    'name' => 'isite::phones',
    'type' => 'select',
    'group' => 'isite::common.settingGroups.contact',
    'props' => [
      'label' => 'isite::common.settings.phones',
      'useInput' => true,
      'useChips' => true,
      'multiple' => true,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique'
    ]
  ],
  'addresses' => [
    'value' => [],
    'name' => 'isite::addresses',
    'type' => 'select',
    'group' => 'isite::common.settingGroups.contact',
    'props' => [
      'label' => 'isite::common.settings.addresses',
      'useInput' => true,
      'useChips' => true,
      'multiple' => true,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique'
    ]
  ],
  'emails' => [
    'value' => [],
    'name' => 'isite::emails',
    'type' => 'select',
    'group' => 'isite::common.settingGroups.contact',
    'props' => [
      'label' => 'isite::common.settings.emails',
      'useInput' => true,
      'useChips' => true,
      'multiple' => true,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique'
    ]
  ],
  //Custom
  'customCss' => [
    'value' => null,
    'name' => 'isite::customCss',
    'type' => 'input',
    'group' => 'isite::common.settingGroups.customSources',
    'props' => [
      'label' => 'isite::common.settings.customCss',
      'type' => 'textarea',
      'rows' => 3,
    ],
  ],
  'customJs' => [
    'value' => null,
    'name' => 'isite::customJs',
    'type' => 'input',
    'group' => 'isite::common.settingGroups.customSources',
    'props' => [
      'label' => 'isite::common.settings.customJs',
      'type' => 'textarea',
      'rows' => 3,
    ],
  ],
];
