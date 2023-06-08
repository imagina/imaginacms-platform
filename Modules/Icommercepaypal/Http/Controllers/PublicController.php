<?php

namespace Modules\Icommercepaypal\Http\Controllers;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base
use Modules\Core\Http\Controllers\BasePublicController;

// Repositories
use Modules\Icommercepaypal\Repositories\IcommercePaypalRepository;
use Modules\Icommerce\Repositories\OrderRepository;

// Entities
use Modules\Icommercepaypal\Entities\Paypal;

use Modules\Icommercepaypal\Http\Controllers\Api\IcommercePaypalApiController;

class PublicController extends BasePublicController
{

    private $icommercepaypal;
    private $order;
    private $paypalApiController;

    public function __construct(
        IcommercePaypalRepository $icommercepaypal,
        IcommercePaypalApiController $paypalApiController,
        OrderRepository $order
    )
    {
        $this->icommercepaypal = $icommercepaypal;
        $this->order = $order;
        $this->paypalApiController = $paypalApiController;
    }


    /**
    * Response Frontend After the Payment
    * @param  $request ()
    * @param  $orderId
    * @param  $transactionId
    * @return redirect
    */
    public function response(Request $request,$orderId,$transactionId){

        $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
        $isQuasarAPP = env("QUASAR_APP", false);

        // Validation Request
        if(isset($request->token)){

            $order = $this->order->find($orderId);
            \Log::info('Module Icommercepaypal: Order Status Id: '.$order->status_id);

            //Check Confirmation
            $this->paypalApiController->confirmation($request,$order,$transactionId);
                
            // Reedirection
            if(!$isQuasarAPP){
                if (!empty($order))
                    return redirect($order->url);
                else
                    return redirect()->route('homepage');

            }else{
                return view('icommerce::frontend.orders.closeWindow');
            }

        }else{

          if(!$isQuasarAPP){
            return redirect()->route('homepage');
          }else{
            return view('icommerce::frontend.orders.closeWindow');
          }

        }

    }


}
