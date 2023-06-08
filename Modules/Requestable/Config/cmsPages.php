<?php

return [
  'admin' => [
    'categories' => [
      'permission' => 'requestable.categories.manage',
      'activated' => true,
      'authenticated' => true,
      'path' => '/requestable/categories',
      'name' => 'qrequestable.admin.categories',
      'crud' => 'qrequestable/_crud/categories',
      'page' => 'qcrud/_pages/admin/crudPage',
      'layout' => 'qsite/_layouts/master.vue',
      'title' => 'requestable.cms.sidebar.categories',
      'icon' => 'fas fa-layer-group',
      'subHeader' => [
        'refresh' => true,
      ]
    ],
    "status" => [
      "permission" => "requestable.statuses.manage",
      "activated" => false,
      "authenticated" => true,
      "path" => "/requestable/status",
      "name" => "qrequestable.admin.status",
      "crud" => "qrequestable/_crud/status",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "requestable.cms.sidebar.status",
      "icon" => "fas fa-flag",
      "subHeader" => [
        "refresh" => true
      ]
    ]
  ],
  'panel' => [],
  'main' => [
    "requestables" => [
      "permission" => "requestable.requestables.manage",
      "activated" => true,
      "authenticated" => true,
      "path" => "/requestable/index",
      "name" => "qrequestable.main.requestables",
      "page" => "qrequestable/_pages/main/kanbanRequesTable",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "requestable.cms.sidebar.mainRequestable",
      "icon" => "fas fa-file-signature",
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "newRequestable" => [
      "permission" => "requestable.requestables.create",
      "activated" => true,
      "authenticated" => true,
      "path" => "/requestable/create",
      "name" => "qrequestable.main.requestables.create",
      "page" => "qrequestable/_pages/main/formRequest",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "requestable.cms.sidebar.mainRequestableCreate",
      "icon" => "fas fa-file-signature",
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "requestable_cms_main_requestables"
        ]
      ]
    ]
  ]
];
