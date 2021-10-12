<?php

return [
  'media.medias' => [
    'index' => 'media::media.list resource',
    'manage' => 'media::media.manage resource',
    'index-all' => 'media::media.list-all resource',
    'create' => 'media::media.create resource',
    'edit' => 'media::media.edit resource',
    'show' => 'media::media.show resource',
    'destroy' => 'media::media.destroy resource',
    'download' => 'media::media.download resource',
  ],
  'media.folders' => [
    'index' => 'media::folders.list resource',
    'index-all' => 'media::media.list-all resource',
    'create' => 'media::folders.create resource',
    'edit' => 'media::folders.edit resource',
    'show' => 'media::folders.show resource',
    'destroy' => 'media::folders.destroy resource',
  ],
  'media.batchs' => [
    'move' => 'media::media.move resource',
    'destroy' => 'media::media.destroy resource',
  ],
  'media.zones' => [
    'index' => 'media::zones.list resource',
    'manage' => 'media::zones.manage resource',
    'index-all' => 'media::zones.list-all resource',
    'create' => 'media::zones.create resource',
    'edit' => 'media::zones.edit resource',
    'show' => 'media::zones.show resource',
    'destroy' => 'media::zones.destroy resource'
  ],

];
