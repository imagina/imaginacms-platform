<?php

return [
  'admin' => [
    "blocks" => [
      "permission" => 'ibuilder.blocks.manage',
      "activated" => true,
      "authenticated" => true,
      "path" => '/builder/blocks',
      "name" => 'qbuilder.admin.blocks.index',
      "crud" => 'qbuilder/_crud/blocks',
      "page" => 'qcrud/_pages/admin/crudPage',
      "layout" => 'qsite/_layouts/master.vue',
      "title" => 'ibuilder.cms.sidebar.adminBlocks',
      "icon" => 'fa-light fa-puzzle-piece',
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "formConfigBlock" => [
      "permission" => 'ibuilder.blocks.create',
      "activated" => true,
      "path" => '/builder/blocks/create',
      "name" => 'qbuilder.admin.blocks.create',
      "page" => 'qbuilder/_pages/admin/formBlock',
      "layout" => 'qsite/_layouts/master.vue',
      "title" => 'ibuilder.cms.newBlock',
      "icon" => 'fa-light fa-square-pen',
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => ['ibuilder_cms_admin_blocks']
      ]
    ],
    "formUpdateBlock" => [
      "permission" => 'ibuilder.blocks.create',
      "activated" => true,
      "path" => '/builder/blocks/:id',
      "name" => 'qbuilder.admin.blocks.update',
      "page" => 'qbuilder/_pages/admin/formBlock',
      "layout" => 'qsite/_layouts/master.vue',
      "title" => 'ibuilder.cms.updateBlock',
      "icon" => 'fa-light fa-square-pen',
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => ['ibuilder_cms_admin_blocks']
      ]
    ],
    "formUpdateClientBlock" => [
      'viewType' => 'client',
      "permission" => 'ibuilder.blocks.client',
      "activated" => true,
      "path" => '/builder/blocks/client/:id',
      "name" => 'qbuilder.admin.client.update',
      "page" => 'qbuilder/_pages/admin/formBlock',
      "layout" => 'qsite/_layouts/master.vue',
      "title" => 'ibuilder.cms.updateBlock',
      "icon" => 'fa-light fa-square-pen',
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ]
  ],
  'panel' => [],
  'main' => []
];
