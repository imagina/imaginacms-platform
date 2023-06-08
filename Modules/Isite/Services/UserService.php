<?php

namespace Modules\Isite\Services;

use Modules\User\Entities\Sentinel\User;
use Modules\User\Repositories\UserRepository;
use Modules\User\Repositories\UserTokenRepository;
use Modules\Iprofile\Entities\Role;
use Modules\Core\Console\Installers\Scripts\UserProviders\SentinelInstaller;
use Modules\Iprofile\Http\Controllers\Api\AuthApiController;

class UserService
{

    private $userTokenRepository;

    public function __construct(
        UserTokenRepository $userTokenRepository
    ){
      $this->userTokenRepository = $userTokenRepository;
    }
   
    public function create(array $data)
    {
        \Log::info("----------------------------------------------------------");
        \Log::info("Creating User in the Tenant DB | Role ".$data["role"]->slug);
        \Log::info("----------------------------------------------------------");

        if (!isset(tenant()->id))
            if (isset($data["organization_id"]))
                tenancy()->initialize($data["organization_id"]);
    
        $password = $data["password"] ?? Str::random(16);
        $info = [
            'first_name' => $data["first_name"] ?? "temporal first name",
            'last_name' => $data["last_name"] ?? "temporal last name",
            'email' => $data["email"],
            'password' => $password,
        ];
    
        $user = app(UserRepository::class)->createWithRolesFromCli($info, [$data["role"]->id ?? 1], true);
        $this->userTokenRepository->generateFor($user->id);
        
        return [
            "user" => $user,
            "credentials" => [
                "email" => $data["email"],
                "password" => $password
            ]
        ];

    }

    public function createSadmin(array $data)
    {

        //Creating a Tenant
        if(isset($data['layout'])){
            $layout = config("tenancy.layouts.".$data['layout']);
            $password = $layout["supassword"]."_".$data['organization_id'];
        }else{
            //Creating a layout
            $password = $data['supassword'];
        }

        $dataToCreate = [
            "first_name" => "Imagina",
            "last_name" => "Colombia",
            "email" => "soporte@imaginacolombia.com",
            "role" => $data['role'],
            "password" => $password,
            "organization_id" => $data['organization_id']
        ];

        $sAdmin = $this->create($dataToCreate);

        return $sAdmin;
    }

    public function configureModule($data)
    {
    
        \Log::info("----------------------------------------------------------");
        \Log::info("Configuring User Module");
        \Log::info("----------------------------------------------------------");
        
        if (!isset(tenant()->id))
        tenancy()->initialize($data["organization_id"]);
        
        $userProvider = app(SentinelInstaller::class);
        
        $userProvider->configure();
        
        \Artisan::call('module:migrate', ['module' => 'User']);
        \Log::info(\Artisan::output());
        \Artisan::call('module:seed', ['module' => 'User']);
        \Log::info(\Artisan::output());
        \Artisan::call('db:seed', ['--class' => 'Modules\Iprofile\Database\Seeders\RolePermissionsSeeder']);
        \Log::info(\Artisan::output());
    
    }

    public function authenticate($data)
    {
  
        \Log::info("----------------------------------------------------------");
        \Log::info("Authenticating user in the Tenant DB");
        \Log::info("----------------------------------------------------------");
    
        if (!isset(tenant()->id))
        tenancy()->initialize($data["organization_id"]);
        
        $authApiController = app(AuthApiController::class);
        
        return json_decode($authApiController->authAttempt($data["credentials"])->content());
    }

}