<?php
return [
  'admin' => [
    "categories" => [
      "permission" => "iappointment.categories.manage",
      "activated" => true,
      "authenticated" => true,
      "path" => "/appointment/categories/index",
      "name" => "qappointment.admin.categories",
      "crud" => "qappointment/_crud/categories",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iappointment.cms.sidebar.adminCategories",
      "icon" => "fas fa-layer-group",
      "subHeader" => [
        "refresh" => true
      ]
    ]
  ],
  'panel' => [
    "appointmentCustomerShow" => [
      "permission" => "iappointment.appointments.customer-show",
      "activated" => true,
      "authenticated" => true,
      "path" => "/appointments/customer/:id",
      "name" => "qappointment.panel.appointments.index",
      "page" => "qappointment/_pages/panel/appointmentCustomerShow",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iappointment.cms.sidebar.panelAppointments",
      "icon" => "fas fa-clipboard-check",
      "subHeader" => [
        "refresh" => true
      ]
    ],
    "appointmentAssignedIndex" => [
      "permission" => "iappointment.appointments.assigned-index",
      "activated" => true,
      "authenticated" => true,
      "path" => "/appointments/assigned/index",
      "name" => "qappointment.panel.appointments.assigned.index",
      "page" => "qappointment/_pages/panel/appointmentAssignedIndex",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "isite.cms.label.chat",
      "icon" => "fas fa-comments",
      "subHeader" => [
        "refresh" => true
      ]
    ]
  ],
  'main' => [
    "appointmentIndex" => [
      "permission" => "iappointment.appointments.index",
      "activated" => true,
      "authenticated" => true,
      "path" => "/appointments/index",
      "name" => "qappointment.main.appointments.index",
      "crud" => "qappointment/_crud/appointments",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "iappointment.cms.sidebar.panelAppointments",
      "icon" => "fas fa-clipboard-check",
      "subHeader" => [
        "refresh" => true
      ]
    ]
  ]
];
