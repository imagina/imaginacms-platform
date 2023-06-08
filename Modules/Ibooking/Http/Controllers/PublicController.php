<?php

namespace Modules\Ibooking\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;
use Route;

use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Core\Http\Controllers\BasePublicController;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

//Entities
use Modules\Ibooking\Repositories\ServiceRepository;
use Modules\Ibooking\Entities\Resource;
use Modules\Ibooking\Transformers\ResourceTransformer;


class PublicController extends BaseApiController
{

  /*
  * Attributes
  */
  private $service;


  /*
  * Contruct
  */
  public function __construct(
    ServiceRepository $service
  )
  {

    parent::__construct();
    $this->service = $service;
  }

  /*
  * Buy Service
  */
  public function buyService(Request $request, $serviceId = null)
  {


    $cartService = app("Modules\Icommerce\Services\CartService");

    // Get Data
    $data = $request->all();


    if (!$serviceId)
      $serviceId = $data['serviceId'] ?? null;


    if (empty($planId))
      return redirect()->back()->withErrors([trans('ibooking::services.messages.selectService')]);


    // Search Service
    $params = json_decode(json_encode(
      [
        "include" => [],
        "filter" => [
          "status" => 1
        ]
      ]
    ));
    $service = $this->service->getItem($serviceId, $params);

    // Set Products to Cart
    $products = [[
      "id" => $service->product->id,
      "quantity" => 1,
      "options" => $data
    ]];

    // Create the Cart
    $cartService->create([
      "products" => $products
    ]);

    // Reedirect to Checkout
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
    return redirect()->route($locale . '.icommerce.store.checkout');

  }

  public function showResources(Request $request, $resourceId)
  {
    //Search resource
    $resource = Resource::with('services')->find($resourceId);
    $tpl = 'ibooking::frontend.showResource';

    //Validate
    if (!$resource) return abort(404);

    //Transforme data
    $resource = json_decode(json_encode(ResourceTransformer::transformData($resource)));

    //dd($resource);

    //Response
    return view($tpl, compact('resource'));
  }
}
