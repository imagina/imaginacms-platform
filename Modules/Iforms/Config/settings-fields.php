<?php

return [
  'usersToNotify' => [
    'name' => 'iforms::usersToNotify',
    'value' => [],
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.quser.users',
      'select' => ['label' => 'email', 'id' => 'id'],
    ],
    'props' => [
      'label' => 'iforms::common.setting.usersToNotify',
      'multiple' => true,
      'clearable' => true,
    ],
  ],
  
  
  'from-email' => [
    'name' => 'iforms::from-email',
    'value' => null,
    'type' => 'input',
    'columns' => 'col-12 col-md-6',
    'props' => [
      'label' => 'iforms::common.setting.email'
    ],
  ],
  'form-emails' => [
    'name' => 'iforms::form-emails',
    'value' => [],
    'type' => 'select',
    'props' => [
      'useInput' => true,
      'useChips' => true,
      'multiple' => true,
      'hint' => 'iforms::common.settingHints.emails',
      'hideDropdownIcon' => true,
      'newValueMode' => 'add-unique',
      'label' => 'iforms::common.setting.emails'
    ],
  ],
  
];
