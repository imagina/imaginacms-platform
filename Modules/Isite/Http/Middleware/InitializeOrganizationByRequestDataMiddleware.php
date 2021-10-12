<?php

namespace Modules\Isite\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Mockery\CountValidator\Exception;
use Modules\Isite\Entities\Organization;
use Modules\Setting\Contracts\Setting;

class InitializeOrganizationByRequestDataMiddleware extends BaseApiController
{
  private $setting;

  public function __construct(Setting $setting)
  {
    $this->setting = $setting;
  }


  public function handle(Request $request, Closure $next)
  {
    try {
   
      $query = $request->query();
      $header = $request->header();
      if(isset($query["organizationId"]) || isset($header["organizationid"])){
        $tenant = Organization::find($query["organizationId"] ?? $header["organizationid"][0] ?? null);
        tenancy()->initialize($tenant);
      
       
      }
      //dd(config("filesystems.disks.local"),config("filesystems.disks.public"),config("filesystems.disks.publicmedia"),config("tenancy.filesystem"));
 
    } catch (\Exception $error) {
      \Log::info($error->getMessage().' '.$error->getFile().' '.$error->getLine());
    }

    return $next($request);
  }
}
