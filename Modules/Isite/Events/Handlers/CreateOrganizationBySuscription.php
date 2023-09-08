<?php

namespace Modules\Isite\Events\Handlers;

use Modules\User\Entities\Sentinel\User;
use Modules\Isite\Entities\Organization;
use Modules\Iprofile\Entities\Role;

use Illuminate\Http\Request;

// Events
use Modules\Isite\Events\OrganizationWasCreated;

class CreateOrganizationBySuscription
{
    private $tenantService;

    private $rolesToTenant;
  private $log = "Isite:: Events|CreateOrganizationBySuscription|";
  private $authApi;

    public function __construct(
  ) {
        $this->tenantService = app("Modules\Isite\Services\TenantService");
    $this->rolesToTenant = json_decode(setting("isite::rolesToTenant",null,"[]"));
    $this->authApi = app("Modules\Iprofile\Http\Controllers\Api\AuthApiController");
    }

    public function handle($event)
    {
    
    \Log::info($this->log);

        try {
            $suscription = $event->model;

            if ($suscription->entity == "Modules\User\Entities\Sentinel\User") {
                $user = User::find($suscription->entity_id);

        if(count($user->organizations)>0){

          //$organization = $user->organizations->first();
          \Log::info($this->log."User already has an organization");

        }else{

          if(!is_null(config("tenancy.mode"))){

            $typeDB = config("tenancy.mode");

            //Like Weigo
            if($typeDB=="multiDatabase"){

              //Logout from Wizard (Central DB)
              if(\Auth::check())
                $this->authApi->logout(app('request'));
              
              //Rol in Central
              $user = $this->updateRoleUser($user,true);

              //Set Core
              config(['asgard.core.config.userstamping' => false]);

              $result = $this->createMultiTenant($user,$suscription);

              //Set Core
              config(['asgard.core.config.userstamping' => true]);

              return $result;

            }else{
              //LIKE DEEV
                $user = $this->updateRoleUser($user);
                $organization = $this->createTenant($user, $suscription);

                tenancy()->initialize($organization->id);

                event(new OrganizationWasCreated($organization));

              return ['data' => true];
            }

            }
      
        }
        
      }
      
        } catch (\Exception $e) {
        \Log::info($e->getMessage().' '.$e->getFile().' '.$e->getLine());
            dd($e);
            \Log::info($e->getMessage().' '.$e->getFile().' '.$e->getLine());
        }
    }

  public function updateRoleUser(object $user,$central = false)
    {

    \Log::info($this->log.'UpdateRoleUser');

    if($central){
      //Set Rol in Central Database when is used Wizard Frontend
      $role = Role::where("slug", config("tenancy.defaultCentralRole"))->first();
      $roles[] = $role->id;
    }else{
      $roles = $this->rolesToTenant;
    }

    $user->roles()->sync($roles);

        return $user;
    }

    public function createTenant(object $user, object $suscription)
    {

    \Log::info($this->log.'CreateTenant');

        $data = [
            'user' => $user,
            'title' => $suscription->options->organization_name,
            'layout_id' => (int) $suscription->options->layout_id,
            'category_id' => (int) $suscription->options->category_id,
            'role_id' => (int) $this->rolesToTenant[0], //To sync in table user_organization to after get example: $organization->users->first()->email
        ];

        $organization = $this->tenantService->createTenant($data);

        return $organization;
    }

  public function createMultiTenant(object $user,object $suscription)
  {

    \Log::info($this->log.'CreateMultiTenant');

    //Layout
    $layoutId = (int)$suscription->options->layout_id;
    //$params = ["filter" => ["field" => "system_name"]];
    $layout = app("Modules\Isite\Repositories\LayoutRepository")->getItem($layoutId);

    $fakePassword = \Str::random(16);//This will be updated later

    //Data User
    $userData = [
      "user" => $user,
      "credentials" => [
          "email" => $suscription->options->email,
          "password" => $fakePassword
      ]
    ];

    //Data To Service (Params like endpoint)
    $data = [
      'email' => $suscription->options->email,
      'first_name' => $user->first_name,
      'last_name' => $user->last_name,
      'title' => $suscription->options->organization_name,
      "password" => $fakePassword,
      'layout' => $layout->system_name,
      'category_id' => $suscription->options->category_id,
      'userData' => $userData
    ];

    /**
     * @param $data
     * @param $autenticationType (credentials (default))
     */
    $response = $this->tenantService->createTenantInMultiDatabase($data);

    
    return $response;
   
  }
  
}
