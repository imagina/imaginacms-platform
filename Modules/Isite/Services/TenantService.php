<?php

namespace Modules\Isite\Services;

use Modules\Iprofile\Entities\Role;
use Modules\Isite\Entities\Module;
use Modules\Isite\Entities\Organization;
use Modules\Isite\Transformers\OrganizationTransformer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Modules\Iprofile\Entities\Setting;

//Services
use Modules\Isite\Services\LayoutService;
use Modules\Isite\Services\SettingService;
use Modules\Isite\Services\UserService;

class TenantService
{

  private $application;
  
  private $layoutService;
  private $settingService;
  private $userService;
  private $isCreatingLayout;
  
  public function __construct(
    LayoutService $layoutService,
    SettingService $settingService,
    UserService $userService
  ){
    $this->layoutService = $layoutService;
    $this->settingService = $settingService;
    $this->userService = $userService;
    $this->isCreatingLayout = false;
  }

  public function createTenant($data)
  {

    \Log::info("----------------------------------------------------------");
    \Log::info("Creating Organization...");
    \Log::info("----------------------------------------------------------");
    
    if (!isset(tenant()->id))
      if (isset($data["organization_id"])) {
        tenancy()->initialize($data["organization_id"]);
      }

    $organization = Organization::create(array_merge([
      'user_id' => $data["user"]->id,
      'title' => $data["title"] ?? $data["user"]->present()->fullname,
      'status' => $data["status"] ?? json_decode(setting("isite::defaultTenantStatus", null, "true")),
      'layout_id' => $data["layout_id"] ?? json_decode(setting("isite::defaultLayout", null, null)),
      'enable' => $data["enable"] ?? json_decode(setting("isite::defaultTenantStatus", null, "true")),
      'category_id' => $data["category_id"] ?? null
    ], $data["organization"] ?? $data["extraData"] ?? []));
    
    Storage::disk("privatemedia")->makeDirectory("organization" . $organization->id);
    Storage::disk("local")->makeDirectory("/storage/organization" . $organization->id);
    Storage::disk("public")->makeDirectory("organization" . $organization->id);
    Storage::disk("publicmedia")->makeDirectory("organization" . $organization->id);
    
    if (isset($data["role"]->id) || isset($data["role_id"]))
      $organization->users()->sync([$data["user"]->id => ['role_id' => $data["role"]->id ?? $data["role_id"]]]);
    
    $organization->domains()->create([
      'domain' => $data["organization"]["domain"] ?? $data["domain"] ?? $organization->slug.'.'.parse_url(config('app.url'),PHP_URL_HOST),
      'type' => 'default'
    ]);
  
    \Log::info("----------------------------------------------------------");
    \Log::info("Created Organization: ".$organization->title. " | Domain: ".$organization->domain);
    \Log::info("----------------------------------------------------------");
    
    return $organization;
  }
  
  /**
   * CREATE TENANT MULTIDB
   * Required [email, name, plan(blog | icommerce) array or string, layout_id]
   * Optional [password, role, string slug]
   * @param Request $request
   * @return mixed
   */
  public function createTenantInMultiDatabase($data)
  {
    
    //central role
    if (isset($data["role"]) && !empty($data["role"])) {
      $role = Role::where("slug", $data["role"])->first();
    }
    
    if (!isset($role->id)) {
      $role = Role::where("slug", config("tenancy.defaultCentralRole"))->first();
    }
    
    //Create the user in current DB
    \Log::info("----------------------------------------------------------");
    \Log::info("Creating central user with email: ".$data["email"]);
    \Log::info("----------------------------------------------------------");
    $userCentralData = $this->userService->create(array_merge($data, ["role" => $role]));
  
    //Create organization
    $organization = $this->createTenant(array_merge($data, ["user" => $userCentralData["user"]]));
    $domain = $organization->domain;

    //Checking if is a new Layout
    if(!isset($data['layout'])){
      $data['supassword'] = \Str::random(16);
      $layoutCreated = $this->layoutService->create($data,$organization);
      $this->isCreatingLayout = true;
    }
    
    //Initializing Tenant
    \Log::info("----------------------------------------------------------");
    \Log::info("Initializing Tenant ID: $organization->id");
    \Log::info("----------------------------------------------------------");
    tenancy()->initialize($organization->id);
  
    
    //Post install commands
    $this->postInstallCommands(["organization_id" => $organization->id]);
  
    //Migrate Core modules
    $this->migrateCoreModules(["organization_id" => $organization->id]);
  
    //seed User Module in the Tenant DB
    $this->userService->configureModule(["organization_id" => $organization->id]);
    
    //create user in Tenant DB
    $tenantUser = $this->userService->create(array_merge($data, [
      "role" => $role,
      "password" => $userCentralData["credentials"]["password"],
      "organization_id" => $organization->id
    ]));

    ///create super admin in Tenant DB
    $roleSuperAdmin = Role::where("slug", "super-admin")->first();
    $sAdmin = $this->userService-> createSadmin(array_merge($data, [
      "organization_id" => $organization->id,
      "role" => $roleSuperAdmin
    ]));
  
    //seeding Core Modules
    $this->seedCoreModules(["organization_id" => $organization->id, "user" => $tenantUser["user"]]);
    
    //finding admin Role seeded in the previous sentence
    \Log::info("----------------------------------------------------------");
    \Log::info("Assign Admin Role for the user un the Tenant DB");
    \Log::info("----------------------------------------------------------");
    $role = Role::where("slug", "admin")->first();
    $tenantUser["user"]->roles()->sync([$role->id]);
  
    \Log::info("----------------------------------------------------------");
    \Log::info("Turn on all core module permissions for the Admin Role in the Tenant DB ");
    \Log::info("----------------------------------------------------------");
    $this->activateModulesPermissionsInRole(config("asgard.core.config.CoreModules"), $role);
    
    //Setting the work Space to the admin role seeded in the Tenant DB
    \Log::info("----------------------------------------------------------");
    \Log::info("Setting the work Space to the admin role seeded in the Tenant DB");
    \Log::info("----------------------------------------------------------");
    $setting = new Setting([
      "related_id" => $role->id,
      "entity_name" => "role",
      "name" => "workSpace",
      "value" => "iadmin",
    ]);
    $setting->save();
    
    
    //Activate the modules of the plan in the Tenant DB
    if(isset($data['plan']) && !is_null($data['plan'])){

      $this->activatePlan(array_merge($data, ["organization_id" => $organization->id, "role" => $role]));
      
    }else{
      
      //Validation config layout
      if(isset($data['layout']) && !is_null($data['layout'])){

        //Get layout configuration
        $layoutConfig = config("tenancy.layouts.".$data['layout']);

        //Set plan value
        $data['plan'] =  $layoutConfig['plan'];
        $this->activatePlan(array_merge($data, ["organization_id" => $organization->id, "role" => $role]));
      
        //Proccess to clone DB and Media
        $this->cloneTenancyLayout($data,$layoutConfig,$organization,$tenantUser['user']);

      }else{
        \Log::info("Layout configuration is NULL");
      }

    }
    
    //Only when create a layout
    if($this->isCreatingLayout){

      \Log::info("----------------------------------------------------------");
      \Log::info("Creating layout and organization in Tenant DB");
      \Log::info("----------------------------------------------------------");

      $cloneLayout = $layoutCreated->replicate();
      $cloneLayout->save();

      \DB::table("isite__organizations")->insert([
        'id' => $organization->id,
        'user_id' => 1,
        'status' => $organization->status,
        'layout_id' =>$cloneLayout->id,
        'enable' => $organization->enable
      ]);

    }

    //Authenticating user in the Tenant DB
    $authData = $this->userService->authenticate(array_merge($userCentralData, ["organization_id" => $organization->id]));

    \Log::info("----------------------------------------------------------");
    \Log::info("Tenant {{$organization->id}} successfully created");
    \Log::info("----------------------------------------------------------");

    return [
      "suser" => ['supassword'=> $sAdmin['credentials']['password']],
      "credentials" => $userCentralData["credentials"],
      "authData" => $authData,
      "organization" => new OrganizationTransformer($organization),
      "redirectUrl" => "https://".$domain . "/iadmin?authbearer=" . str_replace("Bearer ", "",$authData->data->bearer)."&expiresatbearer=".urlencode($authData->data->expiresDate)
    ];

  }
  
  public function activatePlan($data)
  {
  
    \Log::info("----------------------------------------------------------");
    \Log::info("Activating Plan Modules");
    \Log::info("----------------------------------------------------------");
    
    if (!isset(tenant()->id))
      tenancy()->initialize($data["organization_id"]);
    
    $allPlans = config("tenancy.plans");
    !is_array($data["plan"]) ? $plans = [$data["plan"]] : false;
    
    foreach ($allPlans as $plan => $modules) {
      if (in_array($plan, $plans)) {
        
        \Log::info("Activating Plan: $plan");
        $this->activateModule(["organization_id" => $data["organization_id"], "module" => $modules]);
        
      }
    }

    //Active extra modules
    if(isset($data["module"]) && !empty($data["module"]))
      $this->activateModule($data);
    

  }
  
  public function activateModule($data)
  {
  
    if(!isset($data["module"]) || !isset($data["organization_id"])){
      throw new \Exception("Missing module or organization_id parameters",400);
    }
    
    \Log::info("----------------------------------------------------------");
    \Log::info("Activating Module");
    \Log::info("----------------------------------------------------------");
  
    if (!isset(tenant()->id))
      tenancy()->initialize($data["organization_id"]);
    
    $module = $data["module"];
      !is_array($module) ? $module = [$module] : false;
  
    $superAdminRole = Role::where("slug", "super-admin")->first();
    $role = Role::where("slug", "admin")->first();

    \Illuminate\Support\Facades\Cache::flush("*isite_module_all_modules".(tenant()->id ?? "")."*");
      foreach ($module as $moduleName) {
        $moduleName = ucfirst($moduleName);
        \Log::info("Activating Module: $moduleName");
        \Artisan::call('db:seed', ['--class' => "Modules\\$moduleName\Database\Seeders\\" . $moduleName . "ModuleTableSeeder"]);
        \Log::info(\Artisan::output());
        \Artisan::call('module:migrate', ['module' => $moduleName]);
        \Log::info(\Artisan::output());
        \Artisan::call('module:seed', ['module' => $moduleName]);
        \Log::info(\Artisan::output());
        
        \Log::info("----------------------------------------------------------");
        \Log::info("Turn on all modules permissions for the Super Admin Role and Admin Role in the Tenant DB for the module: $moduleName");
        \Log::info("----------------------------------------------------------");

        $this->activateModulesPermissionsInRole($moduleName, $superAdminRole);
        $this->activateModulesPermissionsInRole($moduleName, $data["role"] ?? $role);

      }
      $this->reseedPageAndMenu($data);
  }
  
  public function migrateCoreModules($data)
  {
 
  
    \Log::info("----------------------------------------------------------");
    \Log::info("Migrating Core Modules");
    \Log::info("----------------------------------------------------------");
  
    if (!isset(tenant()->id))
      tenancy()->initialize($data["organization_id"]);
  
    //dd(tenant()->id);
  
    $coreModules = config("asgard.core.config.CoreModules");
  
    foreach ($coreModules as $module) {
    
      \Log::info("Migrating: " . $module);
      \Artisan::call('module:migrate', ['module' => $module]);
      \Log::info("Migrated: " . $module);
    
      \Log::info(\Artisan::output());
    }
 
    
  }
  
  public function seedCoreModules($data)
  {
    
    \Log::info("----------------------------------------------------------");
    \Log::info("Seeding Core Modules");
    \Log::info("----------------------------------------------------------");
    
    if (!isset(tenant()->id))
      tenancy()->initialize($data["organization_id"]);
    
    $coreModules = config("asgard.core.config.CoreModules");
    
    foreach ($coreModules as $module) {
      \Artisan::call('module:seed', ['module' => $module]);
      \Log::info(\Artisan::output());
    }

  }
  
  public function activateModulesPermissionsInRole($modules, Role $role)
  {
  
    (!is_array($modules)) ? $modules = [$modules] : false;
    
    $modules = Module::whereIn("alias",$modules)->get();
    
    $allPermissions = [];
    
    foreach ($modules as $module){
      $modulePermissions = [];
      foreach ($module->permissions ?? [] as $entity => $permissions){
        foreach ($permissions as $action => $permission){
          $allPermissions[$entity.".$action"] = true;
        }
      }
    }

    //Is creating a tenant - inactive some permissions
    if($this->isCreatingLayout==false && $role->slug=="admin")
      $allPermissions = $this->checkPermissions($allPermissions);
    
    $role->permissions = array_merge($allPermissions,$role->permissions ?? []);
  
    $role->save();
    
  }
  
  public function postInstallCommands($data)
  {
    
    \Log::info("----------------------------------------------------------");
    \Log::info("Post Install Commands");
    \Log::info("----------------------------------------------------------");
    
    if (isset($data["organization_id"]))
      tenancy()->initialize($data["organization_id"]);
    
    $postCommands = [
      ["commandname" => "migrate", '--tenants' => [tenant()->id]],
      ["commandname" => "key:generate", '--tenants' => [tenant()->id]],
      ["commandname" => "passport:install", '--tenants' => [tenant()->id]]
    ];
    exec("export APP_RUNNING_IN_CONSOLE=true");
    foreach ($postCommands as $options) {
      //\Log::info($options);
      \Artisan::call('tenants:run', $options);
      \Log::info(\Artisan::output());
    }
    
  }
  
  public function reseedPageAndMenu($data=null)
  {
    
    \Log::info("----------------------------------------------------------");
    \Log::info("Reseed Page and Menu");
    \Log::info("----------------------------------------------------------");
    
    if (isset($data["organization_id"]))
      tenancy()->initialize($data["organization_id"]);
    
    \Artisan::call('module:seed', ['module' => 'Page']);
    \Log::info(\Artisan::output());
    \Artisan::call('module:seed', ['module' => 'Menu']);
      \Log::info(\Artisan::output());
  }

  public function checkPermissions($permissions)
  {

    $notIncludePermissions = config("tenancy.notIncludePermissions");
    foreach ($notIncludePermissions as $key => $value) {
      if(isset($permissions[$value]))
        $permissions[$value] = false;
    }

    return $permissions;
  }

  public function cloneTenancyLayout(array $data,array $layoutConfig,object $organization,object $tenantUser)
  {
    \Log::info("----------------------------------------------------------");
    \Log::info("Clone Tenancy Layout Proccess");
    \Log::info("----------------------------------------------------------");

    $orgId = $layoutConfig['organizationId'];
    \Log::info("Layout - OrganizationId: ".$orgId);

    //Tenant donde esta guardado el layout
    $orgLayout = \DB::connection("mysql")->table("isite__organizations")
    ->where("id",$orgId)
    ->first();

    // Process DB
    $this->cloneTenancyDB($orgLayout,$organization);

    // Process Media
    $this->cloneTenancyMedia($orgId,$organization);

    //Update layouts ids
    $this->layoutService->updateLayoutId($data,$organization);

    //Update some settings
    $this->settingService->updateSettings($data,$organization,$tenantUser);
    
  }

  public function cloneTenancyDB(object $orgLayout,object $organization)
  {

    \Log::info("========== Clone Tenancy DB ==========");

    $dataToConnect = json_decode($orgLayout->data);
    \Log::info("Connect to Tenancy DB Name: ".$dataToConnect->tenancy_db_name);

    // Get mysql data to connection
    $dataMySql = config('database.connections.mysql');
    $dataMySqlTenant = [
      "database" => $dataToConnect->tenancy_db_name,
      "username" => $dataToConnect->tenancy_db_username,
      "password" => $dataToConnect->tenancy_db_password
    ];

    // Add new data
    $newDataConnection = array_merge($dataMySql,$dataMySqlTenant);

    // Set new connection
    config(['database.connections.newConnectionTenant' => $newDataConnection]);
    \DB::purge('newConnectionTenant');
    \DB::reconnect('newConnectionTenant');
    
    // Get tables to new connection
    $tables = \DB::connection("newConnectionTenant")->select("SHOW TABLES");
    
    \Log::info("Tables Total: ".count($tables));
    \Log::info("Preparing to copy in OrganizationId: ".$organization->id);

    //Only name tables
    $tables = array_map('current',$tables);

    $this->checkTablesAndCopy($tables,$organization);
    
    // Esto creo q no es necesario
    //\DB::disconnect('newConnectionTenant');

    \Log::info("========== Clone Tenancy DB FINISHED ==========");

  }

  public function checkTablesAndCopy(array $tables,object $organization)
  {

    // Desactive validation to insert data from organization layout
    \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    $notIncludeTables = config("tenancy.notIncludeTablesToCopy");

    // Check tables
    foreach($tables as $table)
    {
      
      if(!in_array($table,$notIncludeTables)){
        // Get all data
        $dataToCopy = \DB::connection("newConnectionTenant")->select("SELECT * FROM ".$table);
        if(!is_null($dataToCopy) && count($dataToCopy)>0){
          \Log::info("Copying data from Table: ".$table);
          
          // Clean the DATA
          \DB::table($table)->truncate();

          //Data to copy in each row
          foreach ($dataToCopy as $data) 
          {

            $data = (array)$data;

            //Change organization id if exist
            if(isset($data['organization_id']) && !is_null($data['organization_id']))
                $data['organization_id'] = $organization->id;

            \DB::table($table)->insert($data);

            //Extra validations
            $this->validationOrganization($table,$data,$organization);
            
          }

        }
      }

    }

    // Active again
    \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

  }

  public function validationOrganization(string $table, array $data,object $organization)
  {

    if($table=="isite__organizations"){
     
        //Update
        \DB::table($table)->where("id","=",$data['id'])->update([
          "id" => $organization->id
        ]);

    }

  }

  public function cloneTenancyMedia(int $orgIdLayout,object $organization)
  {
    \Log::info("========== Clone Tenancy MEDIA ==========");

    $source = public_path('organization'. $orgIdLayout.'/assets/media');
    $to = public_path('organization'. $organization->id.'/assets/media');  

    \Log::info("Copy - source: ".$source);
    \Log::info("Copy - to: ".$to);

    \File::copyDirectory($source, $to);

    \Log::info("========== Clone Tenancy MEDIA FINISHED ==========");
  }

  public function updateTenant($data)
  {

    \Log::info("----------------------------------------------------------");
    \Log::info("Update Organizations...");
    \Log::info("----------------------------------------------------------");

    if(isset($data['tenantsId']) && is_array($data['tenantsId'])){
      
      foreach ($data['tenantsId'] as $key => $id){
       $this->proccessUpdateTenant($id);
      }
      
    }else{
      //TODO
      //buscar todos los tenants activos 
      //Actualizalos (foreach) llamando al mismo metodo proccessUpdateTenant($organizationId)
    }

  }

  public function proccessUpdateTenant($organizationId)
  {

    \Log::info("----------------------------------------------------------");
    \Log::info("Proccess Update - OrganizationId: ".$organizationId);
    \Log::info("----------------------------------------------------------");
   
    tenancy()->initialize($organizationId);

    //Core Modules Process
    $this->migrateCoreModules(null);
    $this->seedCoreModules(null);

    //All migrations
    \Artisan::call('module:migrate');
    \Log::info(\Artisan::output());
    
    //All seeder
    \Artisan::call('module:seed');
    \Log::info(\Artisan::output());
  
    $this->reseedPageAndMenu();

    \Log::info("Proccess Update - FINISHED - OrganizationId:".$organizationId);

  }

}