<?php

return [
  //Media
  'logoEmail' => [
    'value' => (object)['setting::mainimage' => null],
    'name' => 'medias_single',
    'fakeFieldName' => 'notification::logoEmail',
    'type' => 'media',
    'groupName' => 'media',
    'groupTitle' => 'isite::common.settingGroups.media',
    'props' => [
      'label' => 'notification::common.settings.logoEmail',
      'zone' => 'setting::mainimage',
      'entity' => "Modules\Setting\Entities\Setting",
      'entityId' => null
    ]
  ],
  'templateEmail' => [
    'value' => 'notification::emails.layouts.default',
    'name' => 'notification::templateEmail',
    'type' => 'select',
    'props' => [
      'label' => 'notification::common.settings.labelTemplateEmail',
      'options' => [
        ['label' => 'Default Template', 'value' => 'notification::emails.layouts.default'],
        ['label' => 'Template 1', 'value' => 'notification::emails.layouts.template-1'],
      ]
    ]
  ],
  'contentEmail' => [
    'value' => 'notification::emails.contents.default',
    'name' => 'notification::contentEmail',
    'type' => 'select',
    'props' => [
      'label' => 'notification::common.settings.labelContentEmail',
      'options' => [
        ['label' => 'Default Content', 'value' => 'notification::emails.contents.default'],
        ['label' => 'Content 1', 'value' => 'notification::emails.contents.content-1'],
      ]
    ]
  ],
];
