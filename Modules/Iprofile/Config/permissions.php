<?php

return [
  'profile.api' => [
    'login' => 'profile::profiles.api.login',
  ],

  'profile.access' => [
    'iadmin' => 'profile::profiles.api.login.iadmin',
    'ipanel' => 'profile::profiles.api.login.iadmin',
  ],

  'profile.user' => [
    'manage' => 'profile::user.manage resource',
    'index' => 'profile::user.list resource',
    'index-by-department' => 'profile::user.list resource',
    'create' => 'profile::user.create resource',
    'edit' => 'profile::user.edit resource',
    'destroy' => 'profile::user.destroy resource',
    'department' => 'profile::user.department resource',
    'impersonate' => 'profile::user.impersonate resource',
    'directory' => 'profile::user.directory resource',
  ],

  'profile.permissions' => [
    'manage' => 'profile::permissions.manage resource',
  ],

  'profile.fields' => [
    'manage' => 'profile::fields.manage resource',
    'index' => 'profile::fields.list resource',
    'create' => 'profile::fields.create resource',
    'edit' => 'profile::fields.edit resource',
    'destroy' => 'profile::fields.destroy resource',
  ],

  'profile.addresses' => [
    'manage' => 'profile::addresses.manage resource',
    'index' => 'profile::addresses.list resource',
    'create' => 'profile::addresses.create resource',
    'edit' => 'profile::addresses.edit resource',
    'destroy' => 'profile::addresses.destroy resource',
  ],

  'profile.departments' => [
    'manage' => 'profile::departments.manage resource',
    'index' => 'profile::departments.list resource',
    'create' => 'profile::departments.create resource',
    'edit' => 'profile::departments.edit resource',
    'destroy' => 'profile::departments.destroy resource',
  ],

  'profile.settings' => [
    'manage' => 'profile::settings.manage resource',
    'index' => 'profile::settings.list resource',
    'create' => 'profile::settings.create resource',
    'edit' => 'profile::settings.edit resource',
    'destroy' => 'profile::settings.destroy resource',
  ],

  'profile.user-departments' => [
    'manage' => 'profile::user-departments.manage resource',
    'index' => 'profile::user-departments.list resource',
    'create' => 'profile::user-departments.create resource',
    'edit' => 'profile::user-departments.edit resource',
    'destroy' => 'profile::user-departments.destroy resource',
  ],

  'profile.role' => [
    'manage' => 'profile::role.manage resource',
    'index' => 'profile::roleapis.list resource',
    'create' => 'profile::roleapis.create resource',
    'edit' => 'profile::roleapis.edit resource',
    'destroy' => 'profile::roleapis.destroy resource',
  ]
];
