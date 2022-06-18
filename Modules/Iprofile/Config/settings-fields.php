<?php

//Options documents types
$optionsDocumentsTypes = [
  ['label' => 'Registro Civil', 'value' => 'RC'],
  ['label' => 'Tarjeta de identidad', 'value' => 'TI'],
  ['label' => 'Cédula de ciudadanía', 'value' => 'CC'],
  ['label' => 'Cédula de extranjería', 'value' => 'CE'],
  ['label' => 'Pasaporte', 'value' => 'PP'],
  ['label' => 'NIT', 'value' => 'NIT'],
];

//Fields
return [
  //Register Users
  'registerUsers' => [
    "onlySuperAdmin" => true,
    'name' => 'iprofile::registerUsers',
    'value' => '1',
    'type' => 'checkbox',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'iprofile::settings.registerUsers'
    ],
  ],
  //Validete register with email
  'validateRegisterWithEmail' => [
    "onlySuperAdmin" => true,
    'name' => 'iprofile::validateRegisterWithEmail',
    'value' => "0",
    'type' => 'checkbox',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'iprofile::settings.validateRegisterWithEmail'
    ],
  ],
  //Admin needs to activate any new user - Slim:
  'adminNeedsToActivateNewUsers' => [
    "onlySuperAdmin" => true,
    'name' => 'iprofile::adminNeedsToActivateNewUsers',
    'value' => "0",
    'type' => 'checkbox',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'iprofile::settings.adminNeedsToActivateNewUsers'
    ],
  ],
  //Admin needs to activate any new user - Slim:
  'allowResetPassword' => [
    "onlySuperAdmin" => true,
    'name' => 'iprofile::allowResetPassword',
    'value' => "1",
    'type' => 'checkbox',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'iprofile::settings.allowResetPassword'
    ],
  ],
  //Enable register with social media
  'registerUsersWithSocialNetworks' => [
    "onlySuperAdmin" => true,
    'name' => 'iprofile::registerUsersWithSocialNetworks',
    'value' => "0",
    'type' => 'checkbox',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'iprofile::settings.registerUsersWithSocialNetworks'
    ],
  ],
  //Enable register with oliticsOfPrivacy
  'registerUserWithPoliticsOfPrivacy' => [
    "onlySuperAdmin" => true,
    'name' => 'iprofile::registerUserWithPoliticsOfPrivacy',
    'value' => null,
    'type' => 'input',
    'props' => [
      'label' => 'iprofile::settings.registerUserWithPoliticsOfPrivacy',
      'type' => 'text'
    ],
  ],
  //Enable register with DataTreatment
  'registerUserWithTermsAndConditions' => [
    "onlySuperAdmin" => true,
    'name' => 'iprofile::registerUserWithTermsAndConditions',
    'value' => null,
    'type' => 'input',
    'props' => [
      'label' => 'iprofile::settings.registerUserWithTermsAndConditions',
      'type' => 'text'
    ],
  ],
  //Roles to show as directory
  'rolesToDirectory' => [
    "onlySuperAdmin" => true,
    'name' => 'iprofile::rolesToDirectory',
    'value' => [2],
    'type' => 'select',
    'props' => [
      'label' => 'iprofile::settings.rolesAsDirectory',
      'multiple' => true,
      'useChips' => true
    ],
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.quser.roles',
      'select' => ['label' => 'name', 'id' => 'id']
    ]
  ],
  //Register extra field cellularphone
  'cellularPhone' => [
    'name' => 'iprofile::registerExtraFields',
    'label' => 'iprofile::settings.settingFields.cellularPhone',
    'group' => 'iprofile::settings.settingGroups.registerExtraFields',
    'children' => [
      'field' => ['name' => 'field', 'value' => 'cellularPhone', 'fakeFieldName' => 'cellularPhone'],
      'type' => ['name' => 'type', 'value' => 'number', 'fakeFieldName' => 'cellularPhone'],
      'active' => [
        'name' => 'active',
        'fakeFieldName' => 'cellularPhone',
        'value' => null,
        'type' => 'checkbox',
        'columns' => 'col-12',
        'props' => ['label' => 'iprofile::settings.settingFields.enabled']
      ],
      'required' => [
        'name' => 'required',
        'fakeFieldName' => 'cellularPhone',
        'value' => null,
        'type' => 'checkbox',
        'columns' => 'col-12',
        'props' => ['label' => 'iprofile::settings.settingFields.required']
      ],
    ]
  ],
  //Register extra field Birtday
  'birthday' => [
    'name' => 'iprofile::registerExtraFields',
    'label' => 'iprofile::settings.settingFields.birthday',
    'group' => 'iprofile::settings.settingGroups.registerExtraFields',
    'children' => [
      'field' => ['name' => 'field', 'value' => 'birthday', 'fakeFieldName' => 'birthday'],
      'type' => ['name' => 'type', 'value' => 'date', 'fakeFieldName' => 'birthday'],
      'active' => [
        'name' => 'active',
        'fakeFieldName' => 'birthday',
        'value' => null,
        'type' => 'checkbox',
        'columns' => 'col-12',
        'props' => ['label' => 'iprofile::settings.settingFields.enabled']
      ],
      'required' => [
        'name' => 'required',
        'fakeFieldName' => 'birthday',
        'value' => null,
        'type' => 'checkbox',
        'columns' => 'col-12',
        'props' => ['label' => 'iprofile::settings.settingFields.required']
      ],
    ]
  ],
  //Register extra field Identification
  'identificationRegister' => [
    'name' => 'iprofile::registerExtraFields',
    'label' => 'iprofile::settings.settingFields.identification',
    'group' => 'iprofile::settings.settingGroups.registerExtraFields',
    'children' => [
      'field' => ['name' => 'field', 'value' => 'documentType', 'fakeFieldName' => 'documentType'],
      'type' => ['name' => 'type', 'value' => 'documentType', 'fakeFieldName' => 'documentType'],
      'options' => ['name' => 'options', 'value' => $optionsDocumentsTypes, 'fakeFieldName' => 'documentType'],
      'active' => [
        'name' => 'active',
        'fakeFieldName' => 'documentType',
        'value' => null,
        'type' => 'checkbox',
        'columns' => 'col-12',
        'props' => ['label' => 'iprofile::settings.settingFields.enabled']
      ],
      'required' => [
        'name' => 'required',
        'fakeFieldName' => 'documentType',
        'value' => null,
        'type' => 'checkbox',
        'columns' => 'col-12',
        'props' => ['label' => 'iprofile::settings.settingFields.required']
      ],
      'availableOptions' => [
        'name' => 'availableOptions',
        'fakeFieldName' => 'documentType',
        'value' => [],
        'type' => 'select',
        'columns' => 'col-12',
        'props' => [
          'label' => 'Availables Document Type',
          'options' => $optionsDocumentsTypes,
          'multiple' => true,
          'useChips' => true
        ]
      ],
    ]
  ],
  //Register extra field Main image
  'mainImage' => [
    'name' => 'iprofile::registerExtraFields',
    'label' => 'iprofile::settings.settingFields.mainImage',
    'group' => 'iprofile::settings.settingGroups.registerExtraFields',
    'children' => [
      'field' => ['name' => 'field', 'value' => 'mainImage', 'fakeFieldName' => 'mainImage'],
      'type' => ['name' => 'type', 'value' => 'media', 'fakeFieldName' => 'mainImage'],
      'active' => [
        'name' => 'active',
        'fakeFieldName' => 'mainImage',
        'value' => null,
        'type' => 'checkbox',
        'columns' => 'col-12',
        'props' => ['label' => 'iprofile::settings.settingFields.enabled']
      ],
      'required' => [
        'name' => 'required',
        'fakeFieldName' => 'mainImage',
        'value' => null,
        'type' => 'checkbox',
        'columns' => 'col-12',
        'props' => ['label' => 'iprofile::settings.settingFields.required']
      ],
    ]
  ],
  //Address extra field Company
  'company' => [
    'name' => 'iprofile::userAddressesExtraFields',
    'label' => 'iprofile::settings.settingFields.company',
    'group' => 'iprofile::settings.settingGroups.addressesExtraFields',
    'children' => [
      'field' => ['name' => 'field', 'value' => 'company', 'fakeFieldName' => 'company'],
      'type' => ['name' => 'type', 'value' => 'text', 'fakeFieldName' => 'company'],
      'active' => [
        'name' => 'active',
        'fakeFieldName' => 'company',
        'value' => null,
        'type' => 'checkbox',
        'columns' => 'col-12',
        'props' => ['label' => 'iprofile::settings.settingFields.enabled']
      ],
      'required' => [
        'name' => 'required',
        'fakeFieldName' => 'company',
        'value' => null,
        'type' => 'checkbox',
        'columns' => 'col-12',
        'props' => ['label' => 'iprofile::settings.settingFields.required']
      ],
    ]
  ],
  //Address extra field Zip code
  'zipCode' => [
    'name' => 'iprofile::userAddressesExtraFields',
    'label' => 'iprofile::settings.settingFields.zipCode',
    'group' => 'iprofile::settings.settingGroups.addressesExtraFields',
    'children' => [
      'field' => ['name' => 'field', 'value' => 'zipCode', 'fakeFieldName' => 'zipCode'],
      'type' => ['name' => 'type', 'value' => 'number', 'fakeFieldName' => 'zipCode'],
      'active' => [
        'name' => 'active',
        'fakeFieldName' => 'zipCode',
        'value' => null,
        'type' => 'checkbox',
        'columns' => 'col-12',
        'props' => ['label' => 'iprofile::settings.settingFields.enabled']
      ],
      'required' => [
        'name' => 'required',
        'fakeFieldName' => 'zipCode',
        'value' => null,
        'type' => 'checkbox',
        'columns' => 'col-12',
        'props' => ['label' => 'iprofile::settings.settingFields.required']
      ],
    ]
  ],
  //Address extra field Identification
  'identificationAddress' => [
    'name' => 'iprofile::userAddressesExtraFields',
    'label' => 'iprofile::settings.settingFields.identification',
    'group' => 'iprofile::settings.settingGroups.addressesExtraFields',
    'children' => [
      'field' => ['name' => 'field', 'value' => 'documentType', 'fakeFieldName' => 'documentType'],
      'type' => ['name' => 'type', 'value' => 'documentType', 'fakeFieldName' => 'documentType'],
      'options' => ['name' => 'options', 'value' => $optionsDocumentsTypes, 'fakeFieldName' => 'documentType'],
      'active' => [
        'name' => 'active',
        'fakeFieldName' => 'documentType',
        'value' => null,
        'type' => 'checkbox',
        'columns' => 'col-12',
        'props' => ['label' => 'iprofile::settings.settingFields.enabled']
      ],
      'required' => [
        'name' => 'required',
        'fakeFieldName' => 'documentType',
        'value' => null,
        'type' => 'checkbox',
        'columns' => 'col-12',
        'props' => ['label' => 'iprofile::settings.settingFields.required']
      ],
      'availableOptions' => [
        'name' => 'availableOptions',
        'fakeFieldName' => 'documentType',
        'value' => [],
        'type' => 'select',
        'columns' => 'col-12',
        'props' => [
          'label' => 'Availables Document Type',
          'options' => $optionsDocumentsTypes,
          'multiple' => true,
          'useChips' => true
        ]
      ],
    ]
  ],
  //Address extra field Extra Info
  'extraInfo' => [
    'name' => 'iprofile::userAddressesExtraFields',
    'label' => 'iprofile::settings.settingFields.extraInfo',
    'group' => 'iprofile::settings.settingGroups.addressesExtraFields',
    'children' => [
      'field' => ['name' => 'field', 'value' => 'extraInfo', 'fakeFieldName' => 'extraInfo'],
      'type' => ['name' => 'type', 'value' => 'textarea', 'fakeFieldName' => 'extraInfo'],
      'active' => [
        'name' => 'active',
        'fakeFieldName' => 'extraInfo',
        'value' => null,
        'type' => 'checkbox',
        'columns' => 'col-12',
        'props' => ['label' => 'iprofile::settings.settingFields.enabled']
      ],
      'required' => [
        'name' => 'required',
        'fakeFieldName' => 'extraInfo',
        'value' => null,
        'type' => 'checkbox',
        'columns' => 'col-12',
        'props' => ['label' => 'iprofile::settings.settingFields.required']
      ],
    ]
  ],
  //Register Users
  'logoutIdlTime' => [
    'name' => 'iprofile::logoutIdlTime',
    'value' => '0',
    'type' => 'input',
    'help' => [
      'description' => 'iprofile::settings.logoutIdlTime.helpText'
    ],
    'props' => [
      'type' => "number",
      'label' => 'iprofile::settings.logoutIdlTime.label'
    ],
  ],

  //==== Auth settings
  //Auth banner
  'authBanner' => [
    'value' => (object)['iprofile::authBanner' => null],
    'name' => 'medias_single',
    'fakeFieldName' => 'iprofile::authBanner',
    'type' => 'media',
    'groupName' => 'register',
    'columns' => 'col-12',
    'groupTitle' => 'iprofile::settings.settingGroups.auth',
    'props' => [
      'label' => 'Banner',
      'zone' => 'iprofile::authBanner',
      'entity' => "Modules\Setting\Entities\Setting",
      'entityId' => null
    ]
  ],
  //auth Title
  'authTitle' => [
    'name' => 'iprofile::authTitle',
    'value' => null,
    'type' => 'input',
    'isTranslatable' => true,
    'groupName' => 'register',
    'groupTitle' => 'iprofile::settings.settingGroups.auth',
    'props' => [
      'label' => 'iprofile::settings.authTitle',
      'clearable' => true
    ],
  ],
  //Roles to register
  'hideLogo' => [
    'name' => 'iprofile::hideLogo',
    'value' => '0',
    'type' => 'select',
    'groupName' => 'register',
    'groupTitle' => 'iprofile::settings.settingGroups.auth',
    'props' => [
      'label' => 'iprofile::settings.hideLogo',
      'options' => [
        ['label' => 'iprofile::settings.yes', 'value' => '1'],
        ['label' => 'iprofile::settings.no', 'value' => '0']
      ]
    ]
  ],
  //auth login caption
  'authLoginCaption' => [
    'name' => 'iprofile::authLoginCaption',
    'value' => null,
    'type' => 'input',
    'isTranslatable' => true,
    'groupName' => 'register',
    'groupTitle' => 'iprofile::settings.settingGroups.auth',
    'props' => [
      'label' => 'iprofile::settings.authLoginCaption',
      'clearable' => true
    ],
  ],
  //auth register caption
  'authRegisterCaption' => [
    'name' => 'iprofile::authRegisterCaption',
    'value' => null,
    'type' => 'input',
    'isTranslatable' => true,
    'groupName' => 'register',
    'groupTitle' => 'iprofile::settings.settingGroups.auth',
    'props' => [
      'label' => 'iprofile::settings.authRegisterCaption',
      'clearable' => true
    ],
  ],
  //Roles to register
  'rolesToRegister' => [
    "onlySuperAdmin" => true,
    'name' => 'iprofile::rolesToRegister',
    'value' => [2],
    'type' => 'select',
    'groupName' => 'register',
    'groupTitle' => 'iprofile::settings.settingGroups.auth',
    'props' => [
      'label' => 'iprofile::settings.rolesToRegister',
      'multiple' => true,
      'useChips' => true
    ],
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.quser.roles',
      'select' => ['label' => 'name', 'id' => 'id']
    ]
  ],
  //Password
  'passwordExpiredTime' => [
    'name' => 'iprofile::passwordExpiredTime',
    'value' => '0',
    'type' => 'select',
    'groupName' => 'register',
    'groupTitle' => 'iprofile::settings.settingGroups.auth',
    'props' => [
      'label' => 'iprofile::settings.passwordExpiredTime',
      'options' => [
        ['label' => 'iprofile::settings.expiredTime.never', 'value' => '0'],
        ['label' => 'iprofile::settings.expiredTime.1 week', 'value' => '7'],
        ['label' => 'iprofile::settings.expiredTime.1 month', 'value' => '30'],
        ['label' => 'iprofile::settings.expiredTime.3 months', 'value' => '90'],
        ['label' => 'iprofile::settings.expiredTime.1 year', 'value' => '365']
      ]
    ],
  ],
  //Password not allow old
  'notAllowOldPassword' => [
    'name' => 'iprofile::notAllowOldPassword',
    'value' => '1',
    'type' => 'checkbox',
    'groupName' => 'register',
    'groupTitle' => 'iprofile::settings.settingGroups.auth',
    'props' => [
      'trueValue' => "1",
      'falseValue' => "0",
      'label' => 'iprofile::settings.notAllowOldPassword'
    ],
  ],


  //==== Tenant settings
  'tenantWithCentralData' => [
    'value' => [],
    'name' => 'iprofile::tenantWithCentralData',
    "onlySuperAdmin" => true,
    'groupName' => 'tenantConfiguration',
    'groupTitle' => 'iprofile::common.settings.tenant.group',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'iprofile::common.settings.tenant.tenantWithCentralData',
      'useInput' => false,
      'useChips' => true,
      'multiple' => true,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'iprofile::common.settings.tenant.entities.roles', 'value' => 'roles'],
        ['label' => 'iprofile::common.settings.tenant.entities.settings', 'value' => 'settings'],
      ]
    ]
  ],
];
