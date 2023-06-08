<?php

return [
  'admin' => [],
  'panel' => [],
  'main' => [
    "shiftsIndex" => [
      "permission" => "icheckin.shifts.manage",
      "activated" => true,
      "authenticated" => true,
      "path" => "/checkin/shifts",
      "name" => "qcheckin.main.shifts.index",
      "crud" => "qcheckin/_crud/shifts",
      "page" => "qcrud/_pages/admin/crudPage",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icheckin.cms.sidebar.Shifts",
      "icon" => "fas fa-user-clock",
      "subHeader" => [
        "refresh" => true
      ]
    ]
  ]
];
