<?php

namespace Modules\Isite\Events\Handlers;

use Modules\Isite\Entities\Organization;
use Modules\Isite\Events\OrganizationWasCreated;
// Events
use Modules\User\Entities\Sentinel\User;

class CreateOrganizationBySuscription
{
    private $tenantService;

    private $rolesToTenant;

    public function __construct(
  ) {
        $this->tenantService = app("Modules\Isite\Services\TenantService");
        $this->rolesToTenant = json_decode(setting('isite::rolesToTenant', null, '[]'));
    }

    public function handle($event)
    {
        \Log::info('Isite:: Events|CreateOrganizationBySuscription');

        try {
            $suscription = $event->model;

            if ($suscription->entity == "Modules\User\Entities\Sentinel\User") {
                $user = User::find($suscription->entity_id);

                $user = $this->updateRoleUser($user);
                $organization = $this->createTenant($user, $suscription);

                tenancy()->initialize($organization->id);

                event(new OrganizationWasCreated($organization));
            }
        } catch (\Exception $e) {
            dd($e);
            \Log::info($e->getMessage().' '.$e->getFile().' '.$e->getLine());
        }
    }

    public function updateRoleUser(object $user)
    {
        \Log::info('Isite:: Events|CreateOrganizationBySuscription|UpdateRoleUser');

        $user->roles()->sync($this->rolesToTenant);

        return $user;
    }

    public function createTenant(object $user, object $suscription)
    {
        \Log::info('Isite:: Events|CreateOrganizationBySuscription|CreateTenant');

        $data = [
            'user' => $user,
            'title' => $suscription->options->organization_name,
            'status' => 1,
            'layout_id' => (int) $suscription->options->layout_id,
            'category_id' => (int) $suscription->options->category_id,
            'role_id' => (int) $this->rolesToTenant[0], //To sync in table user_organization to after get example: $organization->users->first()->email
        ];

        $organization = $this->tenantService->createTenant($data);

        return $organization;
    }
}
