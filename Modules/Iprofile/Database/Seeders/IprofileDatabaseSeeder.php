<?php

namespace Modules\Iprofile\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class IprofileDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->call(DepartmentTableSeeder::class);
    $this->call(UserDepartmentTableSeeder::class);
    $this->call(RolePermissionsSeeder::class);
  }
}
