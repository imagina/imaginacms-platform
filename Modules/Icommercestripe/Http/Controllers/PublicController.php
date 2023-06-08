<?php

namespace Modules\Icommercestripe\Http\Controllers;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base
use Modules\Core\Http\Controllers\BasePublicController;

use Modules\Icommerce\Repositories\TransactionRepository;
use Modules\Icommerce\Repositories\OrderRepository;

// Api
use Modules\Icommercestripe\Http\Controllers\Api\StripeApiController;

// Services
use Modules\Icommercestripe\Services\StripeService;

class PublicController extends BasePublicController
{

    private $order;
    private $transaction;
    private $stripeService;
    private $stripeApi;

    private $paymentMethod;

    public function __construct(
        OrderRepository $order,
        TransactionRepository $transaction,
        StripeService $stripeService,
        StripeApiController $stripeApi
    )
    {
        $this->order = $order;
        $this->transaction = $transaction;
        $this->stripeService = $stripeService;
        $this->stripeApi = $stripeApi;

        // Payment Method Configuration
        $this->paymentMethod = stripeGetConfiguration();
    }


    /**
     * Index data
     * @param Requests request
     * @return route
     */
    public function index($eURL){


        try {

            // Decr
            $infor = stripeDecriptUrl($eURL);
            $orderID = $infor[0];
            $transactionID = $infor[1];

            // Validate get data
            $order = $this->order->find($orderID);
            $transaction = $this->transaction->find($transactionID);
           
            // Get Payment Method Configuration
            $paymentMethod = stripeGetConfiguration();

            //View
            $tpl = 'icommercestripe::frontend.index';
          
            return view($tpl,compact('order','eURL'));


        } catch (\Exception $e) {

            \Log::error('Module Icommercestripe-Index: Message: '.$e->getMessage());
            \Log::error('Module Icommercestripe-Index: Code: '.$e->getCode());

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
    * @param 
    * @return redirect new link to Onboarding Account
    */
    public function connectRefreshUrl(){

        //Get Stripe Configuration to Logged User
        $payoutStripeConfig = $this->stripeService->findPayoutConfigUser();

        if($payoutStripeConfig->value->accountId){
            // Create Account Link
            $accountLink = $this->stripeApi->createLinkAccount($this->paymentMethod->options->secretKey,$payoutStripeConfig->value->accountId);

            return redirect($accountLink);

        }else{

            return redirect(url('/'));
        }
       
    }


}
