<?php

namespace Modules\Iprofile\Database\Seeders;

use Illuminate\Database\Seeder;

class IprofileDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(IprofileModuleTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(UserDepartmentTableSeeder::class);
        $this->call(RolePermissionsSeeder::class);
        $this->call(RolePermissionsToAccessSeeder::class);
        $this->call(IformUserDefaultRegisterTableSeeder::class);
        $this->call(AssignedSettingsInRoles::class);
    }
}
