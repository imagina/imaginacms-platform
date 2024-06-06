<?php

return [
  'welcome-title' => [
    'name' => 'dashboard::welcome-title',
    'value' => null,
    'type' => 'input',
    'isTranslatable' => true,
    'props' => [
      'label' => 'dashboard::dashboard.welcome-title',
    ],
  ],
  'welcome-description' => [
    'name' => 'dashboard::welcome-description',
    'value' => null,
    'type' => 'input',
    'isTranslatable' => true,
    'props' => [
      'label' => 'dashboard::dashboard.welcome-description',
      'type' => 'textarea',
      'rows' => 3,
    ],
  ],
  'welcome-enabled' => [
    'name' => 'dashboard::welcome-enabled',
    'value' => null,
    'type' => 'checkbox',
    'props' => [
      'label' => 'dashboard::dashboard.welcome-enabled'
    ],
  ],
];
