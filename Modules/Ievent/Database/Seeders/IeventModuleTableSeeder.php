<?php

namespace Modules\Ievent\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class IeventModuleTableSeeder extends Seeder
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
      ["config" => "permissions", "name" => "permissions"],
    ];
  
    $moduleRegisterService = app("Modules\Isite\Services\RegisterModuleService");
  
    $moduleRegisterService->registerModule("ievent", $columns, 1);
  }
}
