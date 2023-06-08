<?php

return [
  //Extra field to crud users
  'users' => [
    'jobTitle' => [
      'name' => 'jobTitle',
      'value' => '',
      'type' => 'input',
      'isFakeField' => true,
      'fakeFieldName' => 'settings',
      'columns' => 'col-12 col-md-6',
      'props' => [
        'label' => 'iprofile::common.crudFields.labelJobTitle',
      ],
    ],
    'jobRole' => [
      'name' => 'jobRole',
      'value' => '',
      'type' => 'input',
      'isFakeField' => true,
      'fakeFieldName' => 'settings',
      'columns' => 'col-12 col-md-6',
      'props' => [
        'label' => 'iprofile::common.crudFields.labelJobRole',
      ],
    ],
    'jobEmail' => [
      'name' => 'jobEmail',
      'value' => '',
      'type' => 'input',
      'isFakeField' => true,
      'fakeFieldName' => 'settings',
      'columns' => 'col-12 col-md-6',
      'props' => [
        'label' => 'iprofile::common.crudFields.labelJobEmail',
      ],
    ],
    'jobMobile' => [
      'name' => 'jobMobile',
      'value' => '',
      'type' => 'input',
      'isFakeField' => true,
      'fakeFieldName' => 'settings',
      'columns' => 'col-12 col-md-6',
      'props' => [
        'label' => 'iprofile::common.crudFields.labelJobMobile',
      ],
    ],
  ],
  //Extra field to crud departments
  'departments' => [],
  //Extra field to crud roles
  'roles' => []
];
