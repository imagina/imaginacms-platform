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

        $superAdminGroup = Sentinel::findRoleBySlug('super-admin');
        if (! isset($superAdminGroup->id)) {
            // Create an Admin group
            $groups->createModel()->create(
                [
                    'name' => 'Super Admin',
                    'slug' => 'super-admin',
                ]
            );
        }

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

        $userGroup = Sentinel::findRoleBySlug('user');
        if (! isset($userGroup->id)) {
            // Create an Users group
            $groups->createModel()->create(
                [
                    'name' => 'User',
                    'slug' => 'user',
                ]
            );
        }
    }
}
