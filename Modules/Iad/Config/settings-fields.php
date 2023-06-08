<?php

return [
  'whatsappTextAnuncio' => [
    'value' => '¡Hola! Quiero conocer mas...',
    'name' => 'iad::whatsappTextAnuncio',
    'type' => 'input',
    'props' => [
      'label' => 'Texto de Mensaje Whatsapp en el Anuncio'
    ]
  ],
  'complaintForm' => [
    'value' => null,
    'name' => 'iad::complaintForm',
    'type' => 'select',
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.qform.forms',
      'select' => ['label' => 'title', 'id' => 'id'],
    ],
    'props' => [
      'label' => 'Formulario para Denunciar',
      'multiple' => false,
      'clearable' => true,
    ],
  ],
  'selectLayout' => [
    'value' => "iad-list-item-1",
    'name' => 'iad::selectLayout',
    'type' => 'select',
    'columns' => 'col-6',
    'props' => [
      'label' => 'iad::ads.labelSettingLayout',
      'useInput' => false,
      'useChips' => false,
      'multiple' => false,
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'options' => [
        ['label' => 'Layout 1', 'value' => "iad-list-item-1"],
      ]
    ]
  ],
  //Enable register with oliticsOfPrivacy
  'adWithPoliticsOfPrivacy' => [
    'name' => 'iad::adWithPoliticsOfPrivacy',
    'value' => null,
    'type' => 'input',
    'group' => 'iad::ads.groupAds',
    'props' => [
      'label' => 'iad::ads.adWithPoliticsOfPrivacy',
      'type' => 'text'
    ],
  ],
  //Enable register with DataTreatment
  'adWithTermsAndConditions' => [
    'name' => 'iad::adWithTermsAndConditions',
    'value' => null,
    'type' => 'input',
    'group' => 'iad::ads.groupAds',
    'props' => [
      'label' => 'iad::ads.adWithTermsAndConditions',
      'type' => 'text'
    ],
  ],
  'contactFields' => [
    'name' => 'iad::contactFields',
    'value' => ['phone', 'whatsapp', 'facebook', 'instagram', 'twitter', 'youtube'],
    'type' => 'select',
    'group' => 'iad::ads.groupAds',
    'props' => [
      'multiple' => true,
      'useChips' => true,
      'label' => 'iad::ads.contactFields',
      'options' => [
        ['label' => 'Phone', 'value' => 'phone'],
        ['label' => 'Whatsapp', 'value' => 'whatsapp'],
        ['label' => 'Facebook', 'value' => 'facebook'],
        ['label' => 'Instagram', 'value' => 'instagram'],
        ['label' => 'Twitter', 'value' => 'twitter'],
        ['label' => 'Youtube', 'value' => 'youtube']
      ]
    ],
  ],
  'usersToNotify' => [
    'name' => 'iad::usersToNotify',
    'value' => [],
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.quser.users',
      'select' => ['label' => 'email', 'id' => 'id'],
    ],
    'props' => [
      'label' => 'iad::common.settings.usersToNotify',
      'multiple' => true,
      'clearable' => true,
    ],
  ],
  'ratioLocationFilter' => [
    'name' => 'iad::ratioLocationFilter',
    'value' => null,
    'type' => 'input',
    'group' => 'iad::ads.groupAds',
    'props' => [
      'label' => 'iad::ads.ratioLocationFilter',
      'type' => 'number'
    ],
  ],
  'selectFromMedia' => [
    'name' => 'iad::selectFromMedia',
    'value' => '0',
    'type' => 'select',
    'group' => 'iad::ads.groupAds',
    'props' => [
      'label' => 'iad::ads.selectFromMedia',
      'options' => [
        ['label' => 'iad::ads.yes', 'value' => '1'],
        ['label' => 'iad::ads.no', 'value' => '0'],
      ]
    ],
  ],
  'activateUploadsJob' => [
    'value' => '0',
    "onlySuperAdmin" => true,
    'name' => 'iad::activateUploadsJob',
    'type' => 'checkbox',
    'props' => [
      'label' => 'Activar Job de Subidas automáticas',
      'trueValue' => "1",
      'falseValue' => "0",
    ]
  ],
  'dateInShow' => [
    'value' => '0',
    'name' => 'iad::dateInShow',
    'type' => 'checkbox',
    'group' => 'iad::ads.groupAds',
    'props' => [
      'label' => 'iad::ads.labelSettingDate',
      'trueValue' => "1",
      'falseValue' => "0",
    ]
  ],
  'allowRequestForChecked' => [
    'value' => "0",
    "onlySuperAdmin" => true,
    'name' => 'iad::allowRequestForChecked',
    'type' => 'checkbox',
    'props' => [
      'label' => 'iad::iad.settings.allowRequestForChecked',
      'trueValue' => "1",
      'falseValue' => "0",
    ]
  ]
];
