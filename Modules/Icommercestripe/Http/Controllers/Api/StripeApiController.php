<?php

namespace Modules\Icommercestripe\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Services
use Modules\Icommercestripe\Services\StripeService;


class StripeApiController extends BaseApiController
{

   
    private $stripeService;
   
    public function __construct(StripeService $stripeService){
        $this->stripeService = $stripeService;
    }

    /**
    *  API - Generate Link
    * @param 
    * @return
    */
    public function generateLink($paymentMethod,$order,$transaction){

        \Log::info('Icommercestripe: StripeApi|GenerateLink|OrderId: '.$order->id." transactioId: ".$transaction->id);
           
        try {

            // Set Api Key
            \Stripe\Stripe::setApiKey($paymentMethod->options->secretKey);

            // Make Configuration
            $conf = $this->stripeService->createConfigToTransferGroup($paymentMethod,$order,$transaction);
           

            //$conf = $this->stripeService->createConfigToDestinationCharge($paymentMethod,$order,$transaction);

            // Create a Session
            $response = \Stripe\Checkout\Session::create($conf);
            //\Log::info('Icommercestripe: Generate Link - Response: '.$response);

            return $response;

            
        } catch (\Exception $e) {

            \Log::error('Icommercestripe: StripeApi|GenerateLink|Message: '.$e->getMessage().' - File: '.$e->getFile().' - Line: '.$e->getLine());

            //Message Error
            $status = 500;
            $response = [
                'errors' => $e->getMessage()
            ];
        }

        

        return response()->json($response, $status ?? 200);
    }


    /**
    *  API - Create Account
    * @param 
    * @return
    */
    public function createAccount($secretKey,$attr){

        \Log::info('Icommercestripe: StripeApi|CreateAccount');

        $stripe = new \Stripe\StripeClient($secretKey);

        try {
            
            $data['type'] = $attr['type'] ?? 'express';
            $data['country'] = $attr['country'] ?? 'US';
            
            // Email
            if(isset($attr['email']))
                $data['email'] = $attr['email'];

            /*
            * The recipient ToS agreement is not supported for platforms in US creating accounts in US.
            */
            if($data['country']!='US'){
                
                $data['capabilities'] =  config('asgard.icommercestripe.config.capabilities');

                $data['tos_acceptance'] = config('asgard.icommercestripe.config.tos_acceptance');
            }

            // Create Account
            $response = $stripe->accounts->create($data);

        } catch (Exception $e) {
            
            \Log::error('Icommercestripe: StripeApi|CreateAccount|Message: '.$e->getMessage());
            //Message Error
            $status = 500;
            $response = [
                'errors' => $e->getMessage()
            ];
        }

        return $response;

    }

    /**
    *  API - create Link Account
    * @param $paymentMethod
    * @param
    * @return
    */
    public function createLinkAccount($secretKey,$accountId){

        \Log::info('Icommercestripe: StripeApi|CreateLinkAccount');

        $stripe = new \Stripe\StripeClient($secretKey);

        // Create Account
        //$accountId = $this->createAccount($stripe,$attr);

        // Validate Error created account
        /*
        if(isset($accountId['errors'])){
            $response['error'] =  $accountId['errors']; 
            return $response;
        }
        */

        $accountLink = $stripe->accountLinks->create(
          [
            'account' => $accountId,
            'refresh_url' => route('icommercestripe.connect.refresh.url'),
            'return_url' => url('/iadmin/#/me/profile'),//"https://connect.stripe.com/hosted/oauth?success=true",
            'type' => 'account_onboarding'
          ]
        ); 

        return $accountLink->url;
        
    }

    /**
    *  API - create Login
    * @param $paymentMethod
    * @param
    * @return
    */
    public function createLoginLink($secretKey,$accountId){

        \Log::info('Icommercestripe: StripeApi|CreateLoginLink');

        $stripe = new \Stripe\StripeClient($secretKey);

        $result = $stripe->accounts->createLoginLink($accountId,[]);
        
        return $result;
        
    }

    /**
    *  API - Retrieve Account
    * @param $paymentMethod
    * @param accountId
    * @return
    */
    public function retrieveAccount($secretKey,$accountId){

        $stripe = new \Stripe\StripeClient($secretKey);

        $result = $stripe->accounts->retrieve($accountId,[]);

        return $result;
        
    }

    /**
    *  API - Retrieve Country or All Countries
    * @param $paymentMethod
    * @param accountId
    * @return
    */
    public function retrieveCountry($secretKey,$countryCode=false){

        $stripe = new \Stripe\StripeClient($secretKey);

        if($countryCode)
            $result = $stripe->countrySpecs->retrieve($countryCode, []);
        else
            $result = $stripe->countrySpecs->all(['limit' => 100]);

        return $result;
        
    }


    /**
    *  API - Retrieve Transfer
    * @param $secretKey
    * @param transferId
    * @return
    */
    public function retrieveTransfer($secretKey,$transferId){

        $stripe = new \Stripe\StripeClient($secretKey);

        $result = $stripe->transfers->retrieve($transferId,['expand' => ['destination_payment.balance_transaction']]);

        return $result;
        
    }

    /**
    *  API - Retrieve Balance Transaction
    * @param $secretKey
    * @param balanceI
    * @return
    */
    public function retrieveBalanceTransaction($secretKey,$balanceId){

        $stripe = new \Stripe\StripeClient($secretKey);

        $result = $stripe->balanceTransactions->retrieve($balanceId,[]);

        return $result;
        
    }

 
}