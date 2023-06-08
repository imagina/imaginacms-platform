<?php

namespace Modules\Igamification\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class IgamificationModuleTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();


    $columns = [
      ["config" => "cms-pages", "name" => "cms_pages"],
      ["config" => "cms-sidebar", "name" => "cms_sidebar"],
      ["config" => "config", "name" => "config"],
      ["config" => "crud-fields", "name" => "crud_fields"],
      ["config" => "permissions", "name" => "permissions"],
      ["config" => "settings-fields", "name" => "settings"]
    ];

    $moduleRegisterService = app("Modules\Isite\Services\RegisterModuleService");

    $moduleRegisterService->registerModule("igamification", $columns, 1);
  }
}
