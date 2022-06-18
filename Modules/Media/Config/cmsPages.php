<?php

return [
  'admin' => [
    "index" => [
      "permission" => "media.medias.manage",
      "activated" => true,
      "path" => "/media/index",
      "name" => "app.media.index",
      "page" => "qmedia/_pages/admin/index",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "media.cms.sidebar.adminIndex",
      "icon" => "fas fa-photo-video",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "zones" => [
      "permission" => 'media.zones.manage',
      "activated" => true,
      "path" => '/media/zones',
      "name" => 'app.media.zones',
      "crud" => 'qmedia/_crud/zones',
      "page" => 'qcrud/_pages/admin/crudPage',
      "layout" => 'qsite/_layouts/master.vue',
      "title" => 'media.cms.sidebar.adminZones',
      "icon" => 'fas fa-file-invoice',
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
  ],
  'panel' => [],
  'main' => [
    "selectMediaCKEditor" => [
      "permission" => "media.medias.index",
      "activated" => true,
      "path" => "/media/select",
      "name" => "app.media.select",
      "page" => "qmedia/_pages/admin/selectCkEditor",
      "layout" => "qsite/_layouts/blank.vue",
      "title" => "media.cms.sidebar.adminIndex",
      "icon" => "fas fa-camera-retro",
      "authenticated" => true
    ]
  ]
];
