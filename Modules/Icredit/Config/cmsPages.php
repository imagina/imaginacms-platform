<?php

return [
  'admin' => [],
  'panel' => [],
  'main' => [
    "wallet" => [
      "permission" => "icredit.credits.manage",
      "activated" => true,
      "path" => "/credit/wallet",
      "name" => "qcredit.main.credits.index",
      "page" => "qcredit/_pages/main/wallet",
      "layout" => "qsite/_layouts/master.vue",
      "title" => "icredit.cms.sidebar.adminWallet",
      "icon" => "fas fa-wallet",
      "authenticated" => true,
      "subHeader" => [
        "refresh" => true
      ]
    ]
  ]
];
