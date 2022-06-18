<?php

return [
  //Media
  'logoEmail' => [
    'value' => (object)['notification::logoEmail' => null],
    'name' => 'medias_single',
    'fakeFieldName' => 'notification::logoEmail',
    'type' => 'media',
    'groupName' => 'media',
    'groupTitle' => 'isite::common.settingGroups.media',
    'props' => [
      'label' => 'notification::common.settings.logoEmail',
      'zone' => 'notification::logoEmail',
      'entity' => "Modules\Setting\Entities\Setting",
      'entityId' => null
    ]
  ]
];
