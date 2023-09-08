<?php

namespace Modules\Isite\Jobs;

use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAi implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  private $log = "Isite: Jobs|ProcessAi";
  protected $params;
 
  public function __construct($params = [])
  {
    $this->params = $params;
    $this->queue = "ai";
  }

  public function handle()
  {

    \Log::info($this->log."|================================================ INIT");

    if(isset($this->params['tenantId'])){

      forceInitializeTenant($this->params['tenantId']);

      if(isset($this->params['multiple'])){
        //Multiple Jobs
        app($this->params["baseClass"])->startProcesses();
      }else{
        //All in one Job
        app("Modules\Isite\Services\TenantAiService")->processAi($this->params['tenantId'],null,0);
      }

    }
    
    \Log::info($this->log."|================================================ END");

  }

}
