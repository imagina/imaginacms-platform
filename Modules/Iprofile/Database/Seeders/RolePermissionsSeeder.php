<?php

namespace Modules\Iprofile\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Iprofile\Entities\Department;
use Modules\Iprofile\Entities\Setting;
use Modules\Iprofile\Entities\Role;
use Modules\User\Permissions\PermissionManager;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class RolePermissionsSeeder extends Seeder
{
    private $permissions;
  private $profileRoleRepository;

    public function __construct(PermissionManager $permissions)
    {
        $this->permissions = $permissions;
    $this->profileRoleRepository = app("Modules\Iprofile\Repositories\RoleApiRepository");
    }

    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

    //Added because when the job was called again in the creation of the tenant, it did not find the admin role
    if(isset(tenant()->id))
      forceInitializeTenant(tenant()->id);

        $roles = Sentinel::getRoleRepository();
    
    $params = ["filter" => ["field" => "slug"],"include" => [],"fields" => []];
    $admin = $this->profileRoleRepository->getItem("admin", json_decode(json_encode($params)));

        if (! isset($admin->id)) {
      
      $permissions = $this->permissions->all();
  
      $this->module = app('modules');
      $modules = array_keys($this->module->allEnabled());
  
      $allPermissions = [];
  
      //Get permissions and set true
      foreach ($permissions as $moduleName => $modulePermissions) {
        if(isset($modules[$moduleName]))
          foreach ($modulePermissions as $entityName => $entityPermissions) {
            foreach ($entityPermissions as $permissionName => $permission) {
              $allPermissions["{$entityName}.{$permissionName}"] = true;
            }
          }
      }
      
    }

    // Create or Update data to Role
    $roleData = [
                    'name' => 'Admin',
                    'slug' => 'admin',
      'en' => ['title' => trans("iprofile::roles.types.admin",[],"en")],
      'es' => ['title' => trans("iprofile::roles.types.admin",[],"es")]
    ];

    //Only when create
    if(isset($allPermissions))
      $roleData['permissions'] = $allPermissions;

    $admin = createOrUpdateRole($roleData);

        // Find all other Roles to assign it
        $allOtherRoles = Role::where('slug', '!=', 'super-admin')->get();

        // Create default Setting to the admin (assignedRoles,assignedSettings)
        $adminAssignedRoles = Setting::where('related_id', $admin->id)
          ->where('entity_name', 'role')
          ->where('name', 'assignedRoles')
          ->first();

        if (! isset($adminAssignedRoles->id)) {
            Setting::create(
                [
                    'related_id' => $admin->id,
                    'entity_name' => 'role',
                    'name' => 'assignedRoles',
          'value' => $allOtherRoles->pluck('id')->toArray()
        ]);
    }else{
      $adminAssignedRoles->update([
        "value" => $allOtherRoles->pluck('id')->toArray()
                ]);
        }
    }
}
