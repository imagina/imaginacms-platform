<?php

namespace Modules\User\Database\Seeders;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\User\Permissions\PermissionManager;

class SentinelGroupSeedTableSeeder extends Seeder
{
    private $permissions;

    private $schedule;

    public function __construct(PermissionManager $permissions, Schedule $schedule)
    {
        $this->permissions = $permissions;
        $this->schedule = $schedule;
    }

    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $this->schedule->command('php artisan config:clear');

        $groups = Sentinel::getRoleRepository();

  
    // Create or Update data to Role
    $roleData = [
                    'name' => 'Super Admin',
                    'slug' => 'super-admin',
      'en' => ['title' => trans("iprofile::roles.types.super admin",[],"en")],
      'es' => ['title' => trans("iprofile::roles.types.super admin",[],"es")]
    ];
    $roleSAdmin = createOrUpdateRole($roleData);
    

        $permissions = $this->permissions->all();

        $this->module = app('modules');
        $modules = array_keys($this->module->allEnabled());

        $allPermissions = [];

        //Get permissions and set true
        foreach ($permissions as $moduleName => $modulePermissions) {
            if (in_array($moduleName, $modules)) {
                foreach ($modulePermissions as $entityName => $entityPermissions) {
                    foreach ($entityPermissions as $permissionName => $permission) {
                        $allPermissions["{$entityName}.{$permissionName}"] = true;
                    }
                }
            }
        }
        // Save the permissions
        $superAdminGroup = Sentinel::findRoleBySlug('super-admin');
        $superAdminGroup->permissions = $allPermissions;
        $superAdminGroup->save();

    // Create or Update data to Role
    $roleData = [
                    'name' => 'User',
                    'slug' => 'user',
      'en' => ['title' => trans("iprofile::roles.types.user",[],"en")],
      'es' => ['title' => trans("iprofile::roles.types.user",[],"es")]
    ];
    $roleUser = createOrUpdateRole($roleData);

    
        }

}
