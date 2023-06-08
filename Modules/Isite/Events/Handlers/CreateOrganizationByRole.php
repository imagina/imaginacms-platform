<?php

namespace Modules\Isite\Events\Handlers;

use Modules\Isite\Entities\Organization;

// Events
use Modules\Isite\Events\OrganizationWasCreated;

class CreateOrganizationByRole
{
  
  /**
   * @var Mailer
   */
  
  
  public function handle($event)
  {
    try {
      $user = $event->user;
      
      $data = $event->bindings;
      
      $roles = $user->roles;
      
      $rolesToTenant = json_decode(setting("isite::rolesToTenant",null,"[]"));
      
      $allReadyTenant = Organization::where("user_id",$user->id)->first();

      foreach ($roles as $userRole){
        if(in_array($userRole->id,$rolesToTenant) && !$allReadyTenant){
          $allReadyTenant = true;
          $organization = Organization::create(array_merge([
            'user_id' => $user->id,
            'title' => $user->present()->fullname,
            'status' => json_decode(setting("isite::defaultTenantStatus",null, "true")),
            'layout_id' => json_decode(setting("isite::defaultLayout",null, null)),
            'category_id' => $data["organization"]["category_id"] ?? null
          ],$data["organization"] ?? []));
          
          $organization->users()->sync([$user->id => ['role_id' => $userRole->id]]);
          
          $organization->domains()->create([
            'domain' => $data["organization"]["domain"] ?? $data["domain"] ?? $organization->slug.'.'.parse_url(config('app.url'),PHP_URL_HOST),
            'type' => 'default'
          ]);

          tenancy()->initialize($organization->id);

          event(new OrganizationWasCreated($organization));

        }
      }
      
    } catch (\Exception $e) {
      \Log::info($e->getMessage().' '.$e->getFile().' '.$e->getLine());
    }
    
  }
  
  
}
