<?php

return [
  'admin' => [
    "forms" => [
      "permission" => "iforms.forms.manage",
      "activated" => true,
      "path" => "/form/form",
      "name" => "qform.admin.form.index",
      "crud" => "qform/_crud/crudForms",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iforms.cms.sidebar.adminForm",
      "icon" => "fab fa-wpforms",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "formsDesign" => [
      "permission" => null,
      "activated" => true,
      "path" => "/form/form/:id",
      "name" => "qform.admin.form.design",
      "page" => "qform/_pages/admin/forms/design",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iforms.cms.sidebar.designForm",
      "icon" => "fab fa-wpforms",
      "authenticated" => true
    ],
    "fields" => [
      "permission" => "iforms.fields.manage",
      "activated" => true,
      "path" => "/form/fields/:id",
      "name" => "qform.admin.fields.index",
      "page" => "qform/_pages/admin/fields/index",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iforms.cms.sidebar.adminField",
      "icon" => "fas fa-grip-horizontal",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "iforms_cms_admin_forms"
        ]
      ]
    ],
    "fieldsCreate" => [
      "permission" => null,
      "activated" => true,
      "path" => "/form/fields/create/:formId",
      "name" => "qform.admin.fields.create",
      "page" => "qform/_pages/admin/fields/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iforms.cms.newField",
      "icon" => "fas fa-grip-horizontal",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "fieldsUpdate" => [
      "permission" => null,
      "activated" => true,
      "path" => "/form/fields/:id/update",
      "name" => "qform.admin.fields.update",
      "page" => "qform/_pages/admin/fields/form",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iforms.cms.updateField",
      "icon" => "fas fa-grip-horizontal",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "leads" => [
      "permission" => "iforms.leads.manage",
      "activated" => true,
      "path" => "/form/lead",
      "name" => "qform.admin.leads.index",
      "crud" => "qform/_crud/crudLeads",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iforms.cms.sidebar.adminLead",
      "icon" => "fas fa-leaf",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true,
        "breadcrumb" => [
          "iforms_cms_admin_forms"
        ]
      ]
    ],
    "leadsShow" => [
      "permission" => null,
      "activated" => true,
      "path" => "/form/lead/:id",
      "name" => "qform.admin.leads.show",
      "page" => "qform/_pages/admin/leads/show",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iforms.cms.sidebar.adminLead",
      "icon" => "fas fa-chalkboard-teacher",
      "authenticated" => true
    ]
  ],
  'panel' => [],
  'main' => []
];
