<?php

namespace Modules\Icommercecheckmo\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Icommerce\Http\Controllers\Api\OrderApiController;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Repositories
use Modules\Icommercecheckmo\Repositories\IcommerceCheckmoRepository;

use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Repositories\OrderRepository;


class IcommerceCheckmoApiController extends BaseApiController
{

    private $checkmo;
    private $paymentMethod;
    private $order;
    private $orderController;
   
    public function __construct(
        IcommerceCheckmoRepository $checkmo,
        PaymentMethodRepository $paymentMethod,
        OrderRepository $order,
        OrderApiController $orderController
    ){

        $this->checkmo = $checkmo;
        $this->paymentMethod = $paymentMethod;
        $this->order = $order;
        $this->orderController = $orderController;
    }
    
    /**
     * Init data
     * @param Requests request
     * @param Requests orderid
     * @return route
     */
    public function init(Request $request){

        try {

            $orderID = $request->orderID;
            \Log::info('Icommercecheckmo: Init|orderID:'.$orderID);

            $paymentName = config('asgard.icommercecheckmo.config.paymentName');

            // Configuration
            $params['filter'] = [
                'field' => 'name'
            ];
            $paymentMethod = app("Modules\Icommerce\Repositories\PaymentMethodRepository")->getItem($paymentName,json_decode(json_encode($params)));

            // Order
            $order = $this->order->find($orderID);

            if(is_null($order))
                \Log::info('Icommercecheckmo: Init|order not found');
               
            // Validate minimum amount order
            if(isset($paymentMethod->options->minimunAmount) && $order->total<$paymentMethod->options->minimunAmount)
              throw new \Exception('Total order minimum not allowed', 204);

            // Nothing to reedirect
            $redirectRoute = "";

            // Response
            $response = [ 'data' => [
                "redirectRoute" => $redirectRoute,
                "external" => false
            ]];

            \Log::info('Icommercecheckmo: Init|Finished');
            
          } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
              'errors' => $e->getMessage()
            ];
        }

        return response()->json($response, $status ?? 200);

    }
    
    /**
     * Response Api Method
     * @param Requests request
     * @return route 
     */
    public function response(Request $request){

        /** 
         * Not applicable for this module
         * */ 
        
        // Check the response
        // Update Order Process (icommerce)
        // Check order

    }

}