<?php

namespace Modules\Icustom\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class IcustomModuleTableSeeder extends Seeder
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
      ['config' => 'cmsPages', 'name' => 'cms_pages'],
      ['config' => 'cmsSidebar', 'name' => 'cms_sidebar'],
      ['config' => 'config', 'name' => 'config'],
      ['config' => 'permissions', 'name' => 'permissions'],
    ];

    $moduleRegisterService = app("Modules\Isite\Services\RegisterModuleService");

    $moduleRegisterService->registerModule('icustom', $columns, 1);
  }
}
