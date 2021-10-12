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
      'trueValue'=>"1",
      'falseValue'=>"0",
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
      'trueValue'=>"1",
      'falseValue'=>"0",
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
      'trueValue'=>"1",
      'falseValue'=>"0",
      'label' => 'iprofile::settings.adminNeedsToActivateNewUsers'
    ],
  ],
  //Enable register with social media
  'registerUsersWithSocialNetworks' => [
    "onlySuperAdmin" => true,
    'name' => 'iprofile::registerUsersWithSocialNetworks',
    'value' => "0",
    'type' => 'checkbox',
    'props' => [
      'trueValue'=>"1",
      'falseValue'=>"0",
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
  
  //Roles to register
  'rolesToRegister' => [
    "onlySuperAdmin" => true,
    'name' => 'iprofile::rolesToRegister',
    'value' => [2],
    'type' => 'select',
    'groupName' => 'register',
    'groupTitle' => 'iprofile::settings.settingGroups.register',
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
  
  'authBanner' => [
    'value' => (object)['iprofile::authBanner' => null],
    'name' => 'medias_single',
    'fakeFieldName' => 'iprofile::authBanner',
    'type' => 'media',
    'groupName' => 'register',
    'groupTitle' => 'iprofile::settings.settingGroups.register',
    'props' => [
      'label' => 'Banner para vista de autenticación',
      'zone' => 'iprofile::authBanner',
      'entity' => "Modules\Setting\Entities\Setting",
      'entityId' => null
    ]
  ],
];
