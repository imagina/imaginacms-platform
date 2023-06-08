<?php

namespace Modules\Icommercepaymentez\Http\Controllers;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base
use Modules\Core\Http\Controllers\BasePublicController;

use Modules\Icommerce\Repositories\TransactionRepository;
use Modules\Icommerce\Repositories\OrderRepository;

// Services
use Modules\Icommercepaymentez\Services\PaymentezService;

class PublicController extends BasePublicController
{

    private $order;
    private $transaction;
    private $paymentezService;

    public function __construct(
        OrderRepository $order,
        TransactionRepository $transaction,
        paymentezService $paymentezService
    )
    {
        $this->order = $order;
        $this->transaction = $transaction;
        $this->paymentezService = $paymentezService;
    }


    /**
     * Index data
     * @param Requests request
     * @return route
     */
    public function index($eURL){


        try {

            // Decr
            $infor = paymentezDecriptUrl($eURL);
            $orderID = $infor[0];
            $transactionID = $infor[1];

            // Validate get data
            $order = $this->order->find($orderID);
            $transaction = $this->transaction->find($transactionID);
           
            // Get Payment Method Configuration
            $paymentMethod = paymentezGetConfiguration();

            
            $config = $this->paymentezService->makeConfiguration($paymentMethod,$order,$transaction);

            //View
            $tpl = 'icommercepaymentez::frontend.index';
          
            return view($tpl,compact('config'));


        } catch (\Exception $e) {

            \Log::error('Module Icommercepaymentez-Index: Message: '.$e->getMessage());
            \Log::error('Module Icommercepaymentez-Index: Code: '.$e->getCode());

            //Message Error
            $status = 500;
            $response = [
              'errors' => $e->getMessage(),
              'code' => $e->getCode()
            ];

            return redirect()->route("homepage");

        }
       

    }

    /**
     * Confirmation after payment - redirect
     * @param Requests request
     * @return route
     */
    public function confirmation(Request $request,$orderId){

        //dd($request,$orderId);

        $order = $this->order->find($orderId);
        
        if($order){
            return redirect($order->url);
        }else{
            return redirect()->route('homepage');
        }
    }


}
