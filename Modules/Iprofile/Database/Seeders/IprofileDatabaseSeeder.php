<?php

namespace Modules\Iprofile\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Iprofile\Database\Seeders\IformUserDefaultRegisterTableSeeder;

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
    $this->call(RolePermissionsToAccessSeeder::class);
    //Seed User default register form
    $this->call(IformUserDefaultRegisterTableSeeder::class);
    $this->call(AssignedSettingsInRoles::class);
  }
}
