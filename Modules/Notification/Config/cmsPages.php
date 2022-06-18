<?php

return [
  'admin' => [
    "setting" => [
      "permission" => "notification.notifications.manage",
      "activated" => true,
      "path" => "/notifications/setting",
      "name" => "notification.admin.providers",
      "layout" => "qsite/_layouts/master",
      "page" => "qnotification/_pages/admin/setting/index",
      "title" => "notification.cms.sidebar.adminConfig.title",
      "headerTitle" => "notification.cms.sidebar.adminConfig.headerTitle",
      "icon" => "fab fa-stack-exchange",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ]
  ],
  'panel' => [],
  'main' => []
];
