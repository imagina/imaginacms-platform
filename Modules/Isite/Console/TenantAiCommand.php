<?php


namespace Modules\Isite\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


class TenantAiCommand extends Command
{
    
  protected $signature = 'tenant:ai:run {tenantId} {--execution=} {modules?*}';
  protected $description = 'Run AI Service to tenant
  {tenantId : The ID of the tenant}
  {--execution : 0=run immediately | 1=Multiples Jobs}
  {modules : page blog slider icommerce}';


  public function handle()
  {
        
    $tenantId = $this->argument('tenantId');
    $typeExecution = $this->option('execution') ?? 0;
    $modules = count($this->argument('modules'))>0 ? $this->argument('modules') : null;

    $this->info("Ai Service| START");
    app("Modules\Isite\Services\TenantAiService")->processAi($tenantId,$modules,(int)$typeExecution,true);
    $this->info("Ai Service| COMPLETED");

  }


}