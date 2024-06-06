<?php

namespace Modules\Iprofile\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Iprofile\Entities\Department;
use Modules\User\Permissions\PermissionManager;


class RolePermissionsSeeder extends Seeder
{
  private $permissions;

  public function __construct(PermissionManager $permissions)
  {
    $this->permissions = $permissions;
  }

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    $permissions = $this->permissions->all();
    
    $this->module = app('modules');
    $modules = array_keys($this->module->allEnabled());
    
    $allPermissions = [];


    //Get permissions and set true
    foreach ($permissions as $moduleName => $modulePermissions){
      foreach ($modulePermissions as $entityName => $entityPermissions){
        foreach ($entityPermissions as $permissionName => $permission){
          $allPermissions["{$entityName}.{$permissionName}"] = true;
        }
      }
    }

    //Update permissions of role ID 1
    \DB::table('roles')->where('id',1)->update(['permissions' => json_encode($allPermissions)]);
  }
}
