<?php

namespace Modules\Isite\Console;

use Illuminate\Console\Command;
use Modules\Isite\Repositories\OrganizationRepository;

class TenantsScheduleCommand extends Command
{
    protected $signature = 'tenants:schedule:run';

    protected $description = 'Run all schedule to enabled organizations';

    private $organizationRepository;

    public function __construct(
        OrganizationRepository $organizationRepository
    ) {
        parent::__construct();
        $this->organizationRepository = $organizationRepository;
    }

    public function handle()
    {
        $this->info('PROCCESS INIT');

        $params = ['filter' => ['enable' => 1]];
        $organizations = $this->organizationRepository->getItemsBy(json_decode(json_encode($params)));

        if (! is_null($organizations)) {
            $this->comment('Enabled Organizations: '.$organizations->count());
            foreach ($organizations as $key => $org) {
                $this->line('Run command to Organization: '.$org->id);
                \Artisan::call('php artisan tenant:run schedule:run --tenants="'.$org->id.'"');
            }
        } else {
            $this->comment('Organizations is NULL');
        }

        $this->info('PROCCESS END');
    }
}
