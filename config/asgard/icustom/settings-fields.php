<?php

return [
  'customCssHeader' => [
    'value' => null,
    'name' => 'icustom::customCssHeader',
    'type' => 'input',
    'groupName' => 'Header',
    'groupTitle' => 'icustom::common.settings.groupName.header',
    'colClass' => 'col-12 col-md-12',
    'props' => [
      'label' => 'icustom::common.settings.labelCustomCssHeader',
      'type' => 'textarea',
      'rows' => 12,
    ],
  ],
  'customCssFooter' => [
    'value' => null,
    'name' => 'icustom::customCssFooter',
    'type' => 'input',
    'groupName' => 'Footer',
    'groupTitle' => 'icustom::common.settings.groupName.footer',
    'colClass' => 'col-12 col-md-12',
    'props' => [
      'label' => 'icustom::common.settings.labelCustomCssFooter',
      'type' => 'textarea',
      'rows' => 12,
    ],
  ],

  //Colors
  'colorBackgroundHeader' => [
    'value' => null,
    'name' => 'icustom::colorBackgroundHeader',
    'type' => 'inputColor',
    'groupName' => 'colors',
    'groupTitle' => 'isite::common.settingGroups.colors',
    'colClass' => 'col-12 col-md-6',
    'props' => [
      'label' => 'icustom::common.settings.colorBackgroundHeader'
    ]
  ],
  'colorBackgroundFooter' => [
    'value' => null,
    'name' => 'icustom::colorBackgroundFooter',
    'type' => 'inputColor',
    'groupName' => 'colors',
    'groupTitle' => 'isite::common.settingGroups.colors',
    'colClass' => 'col-12 col-md-6',
    'props' => [
      'label' => 'icustom::common.settings.colorBackgroundFooter'
    ]
  ],
];