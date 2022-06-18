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
      
      $authUser = \Auth::user();
      
      // if the auth couldn't got it, the initialization would bypassed
      if (isset($authUser->id)) {
        
        $organizations = $authUser->organizations;
        $organizationSelected = null;
        $organizations = $organizations->pluck("id")->toArray() ?? null;
        //si existe un payload con header o query solicitando inicializar un tenant
        
        if (isset($query["organizationId"]) || isset($header["organizationid"])) {
          /*
           * si el auth user no tiene organizaciones asignadas se le deja inicializar el tenant
           * o si el auth user si tiene organizaciones asignadas entonces que la que intenta inicializar esté asignada
           */
          if (empty($organizations) || (in_array($query["organizationId"] ?? $header["organizationid"][0], $organizations))) {
            $organizationSelected = $query["organizationId"] ?? $header["organizationid"][0];
          }
          
        }
        
        /*
         * si el auth user tiene organizaciones asignadas y aún no se ha seleccionado una desde el header o query
         * se inicializa la primera que se consiga en el array de organizaciones asignadas
         * con esto si se intenta crear, modificar o eliminar un dato de una organizacion distinta,
         * por defecto lo inicialice en su propia organizacion para evitar con el scope de tenant
         * que ocurra un cambio en los datos de organizaciones ajenas
         */
        if (!empty($organizations) && empty($organizationSelected))
          $organizationSelected = $organizations[0];
        
        
        // se inicializa el tenant si se obtiene una organizacion seleccionada
        if (!empty($organizationSelected))
          tenancy()->initialize($organizationSelected);
        
      }
      
    } catch (\Exception $error) {
      \Log::info($error->getMessage() . ' ' . $error->getFile() . ' ' . $error->getLine());
    }
    
    return $next($request);
  }
}
