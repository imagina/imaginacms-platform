<?php

namespace Modules\Icommerceflatrate\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Repositories
use Modules\Icommerceflatrate\Repositories\IcommerceFlatrateRepository;

use Modules\Icommerce\Repositories\ShippingMethodRepository;


class IcommerceFlatrateApiController extends BaseApiController
{

    private $icommerceFlatrate;
    private $shippingMethod;
   
    public function __construct(
        IcommerceFlatrateRepository $icommerceFlatrate,
        ShippingMethodRepository $shippingMethod
    ){
        $this->icommerceFlatrate = $icommerceFlatrate;
        $this->shippingMethod = $shippingMethod;
    }
    
    /**
     * Init data
     * @param Requests request
     * @param Requests array products - items (object)
     * @param Requests array products - total
     * @return mixed
     */
    public function init(Request $request){

        try {
            $data = $request->all();
            // Configuration
            $shippingName = config('asgard.icommerceflatrate.config.shippingName');
            $attribute = array('name' => $shippingName);
            
            if(isset($data["methodId"])){
              $shippingMethod = $this->shippingMethod->getItem($data["methodId"]);
            }else{
              $shippingMethod = $this->shippingMethod->findByAttributes($attribute);
            }

            $response = $this->icommerceFlatrate->calculate($request->all(),$shippingMethod->options);

           
          } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
              'errors' => $e->getMessage()
            ];
        }

        return response()->json($response, $status ?? 200);

    }
    
    

}