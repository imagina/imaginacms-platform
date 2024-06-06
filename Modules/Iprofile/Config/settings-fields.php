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
    'name' => 'iprofile::registerUsers',
    'value' => null,
    'type' => 'checkbox',
    'props' => [
      'label' => 'iprofile::settings.registerUsers'
    ],
  ],
  //Validete register with email
  'validateRegisterWithEmail' => [
    'name' => 'iprofile::validateRegisterWithEmail',
    'value' => null,
    'type' => 'checkbox',
    'props' => [
      'label' => 'iprofile::settings.validateRegisterWithEmail'
    ],
  ],
  //Admin needs to activate any new user - Slim:
  'adminNeedsToActivateNewUsers' => [
    'name' => 'iprofile::adminNeedsToActivateNewUsers',
    'value' => null,
    'type' => 'checkbox',
    'props' => [
      'label' => 'iprofile::settings.adminNeedsToActivateNewUsers'
    ],
  ],
  //Enable register with social media
  'registerUsersWithSocialNetworks' => [
    'name' => 'iprofile::registerUsersWithSocialNetworks',
    'value' => null,
    'type' => 'checkbox',
    'props' => [
      'label' => 'iprofile::settings.registerUsersWithSocialNetworks'
    ],
  ],
  //Enable register with social media
  'registerUserWithPoliticsOfPrivacy' => [
    'name' => 'iprofile::registerUserWithPoliticsOfPrivacy',
    'value' => null,
    'type' => 'checkbox',
    'props' => [
      'label' => 'iprofile::settings.registerUserWithPoliticsOfPrivacy'
    ],
  ],
  //Roles to show as directory
  'rolesToDirectory' => [
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
];
