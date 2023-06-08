<?php

namespace Modules\Menu\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Menu\Database\Seeders\CMSSidebarDatabaseSeeder;

class MenuDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    //Seed cms pages
    $this->call(MenuModuleTableSeeder::class);
    //$this->call(CMSSidebarDatabaseSeeder::class);
  }
}
