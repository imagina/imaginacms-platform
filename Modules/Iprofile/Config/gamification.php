<?php

$transPrefix = "iprofile::gamification";

return [
  "categories" => [],
  "activities" => [
    [
      'systemName' => 'admin_home_actions_manageUsers',
      'title' => "$transPrefix.activities.manageUsers",
      'description' => "$transPrefix.activities.manageUsersDescription",
      'type' => 1,
      'url' => "iadmin/#/users/index",
      'categoryId' => 'admin_home_actions',
      'icon' => 'fal fa-users',
      'roles' => []
    ],
  ],
];
