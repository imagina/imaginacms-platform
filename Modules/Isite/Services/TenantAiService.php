<?php

namespace Modules\Isite\Services;

use Modules\Isite\Jobs\ProcessAi;

class TenantAiService
{

  private $log = "Isite: TenantAiService|";

  /**
   * @param $tenantId [Case from command]
   * @param $extraData [Case from command] (names: page blog slider icommerce)
   * @param $typeOfExecution (0 = all in one process | 1 = executte in jobs )
   * @param $initTenant [case from command]
   */
  public function processAi($tenantId = null,$extraData = null,$typeOfExecution=0,$initTenant=false)
  {

    \Log::info($this->log."processAi|START");

    //Case command
    if(!is_null($tenantId) && $initTenant){
      \Log::info($this->log."processAi|Command|Initialize Tenant");
      tenancy()->initialize($tenantId);
    }

    $category = tenant()->category->title ?? null;
    \Log::info($this->log."processAi|Tenant|Id: ".tenant()->id."|Category: ".$category);


    //Check execution to services
    if($extraData==NULL || in_array("page",$extraData))
      $this->validateExecution($typeOfExecution,"Modules\Page\Services\PageContentAi",$tenantId);

    if($extraData==NULL || in_array("blog",$extraData)) 
      $this->validateExecution($typeOfExecution,"Modules\Iblog\Services\BlogContentAi",$tenantId);

    if($extraData==NULL || in_array("slider",$extraData))
      $this->validateExecution($typeOfExecution,"Modules\Slider\Services\SliderContentAi",$tenantId);
   
    //Icommerce
    if(\Schema::hasTable('icommerce__products')){
      if($extraData==NULL || in_array("icommerce",$extraData)) 
        $this->validateExecution($typeOfExecution,"Modules\Icommerce\Services\IcommerceContentAi",$tenantId);
    }

    \Log::info($this->log."processAi|END");

  }

 
  public function validateExecution($typeOfExecution,$service,$tenantId)
  {

    if($typeOfExecution==0){
       
        //Like a command
        $results = app($service)->startProcesses();
    }else{
        //Like a job
        \Log::info($this->log."processAi|DispatchJob: ".$service);
        ProcessAi::dispatch([
          "baseClass" =>$service,
          "tenantId" => $tenantId,
          "multiple" => true
        ]);
    }
    
  }
  
  

}