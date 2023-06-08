<?php

namespace Modules\Icommerceopenpay\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

use Openpay\Data\Client as Openpay;

class OpenpayApiController extends BaseApiController
{

    private $gateway;
    private $openpayService;

    public function __construct(){
        $this->gateway = $this->getGateway();
        $this->openpayService = app("Modules\Icommerceopenpay\Services\OpenpayService");
    }

    /**
    * Get gateway
    * @param 
    * @return gateway
    */
    public function getGateway(){

        // Payment Method Configuration
        $paymentMethod = openpayGetConfiguration();

        $isProduction = openpayIsProductionMode($paymentMethod->options->mode);

        Openpay::setProductionMode($isProduction);

        $gateway = Openpay::getInstance(
            $paymentMethod->options->merchantId, 
            $paymentMethod->options->privateKey,
            'CO'
        );

        return $gateway;

    }

    
    /**
    * Create Charge
    * @param 
    * @return result
    */
    public function createCharge($order,$transaction,$token,$deviceId){
        
        \Log::info('Icommerceopenpay: OpenpayApi|createCharge');
       
        try {
            

             // create object customer
            $customer = array(
                'name' => $order->first_name,
                'last_name' => $order->last_name,
                'email' => $order->email
            );
            
            $chargeData = array(
                'method' => 'card',
                'source_id' => $token,
                'amount' => $order->total,
                'currency' => $order->currency_code,
                'description' => openpayGetOrderDescription($order),
                'order_id' => openpayGetOrderRefCommerce($order,$transaction),
                'device_session_id' => $deviceId,
                'customer' => $customer
            );

            $charge = $this->gateway->charges->create($chargeData);

            \Log::info('Icommerceopenpay: Charge Status: '.$charge->status);

            // Format response
            $response = [
                'status'=> 'success',
                'charge' => [
                    'id' => $charge->id,
                    'status' => $charge->status 
                ]
            ];


        } catch (\OpenpayApiTransactionError | \OpenpayApiRequestError | \OpenpayApiConnectionError | \OpenpayApiAuthError | \OpenpayApiError | \Exception $e) {

            \Log::info('Icommerceopenpay: OpenpayApi|createCharge|ERROR: '.$e->getMessage().' Code:'.$e->getErrorCode());
            //error_log('ERROR ' . $e->getCategory() . ': ' . $e->getMessage(), 0);
            $response = [
                'status' => 'error',
                'error' => $e->getMessage(),
                'code' => $e->getErrorCode(),
            ];
        }

        return $response;
    }


    /**
    * Create PSE Request
    * @param 
    * @return result
    */
    public function createPseRequest($order,$transaction){

        \Log::info('Icommerceopenpay: OpenpayApi|createPseRequest');
       
        try {
            
            $customer = array(
                'name' => $order->first_name,
                'last_name' => $order->last_name,
                'email' => $order->email,
                'phone_number' => $order->phone ?? '',
                'requires_account' => false
            );

            $pseRequest = array(
                'amount' => $order->total,
                'currency' => $order->currency_code,
                'description' => openpayGetOrderDescription($order),
                'order_id' => openpayGetOrderRefCommerce($order,$transaction),
                'iva' => $order->tax_amount ?? 0,
                'redirect_url' => $order->url,
                'customer' => $customer
            );

            $pse = $this->gateway->pses->create($pseRequest);

            // Format response
            $response = [
                'status'=> 'success',
                'pse' => [
                    'url' => $pse->redirect_url,
                    'orderId' => $pse->orderid 
                ]
            ];

            \Log::info('Icommerceopenpay: OpenpayApi|createPseRequest|PSE URL: OK');

        } catch (\OpenpayApiTransactionError | \OpenpayApiRequestError | \OpenpayApiConnectionError | \OpenpayApiAuthError | \OpenpayApiError | \Exception $e) {

            \Log::info('Icommerceopenpay: OpenpayApi|createPseRequest|ERROR: '.$e->getMessage().' Code:'.$e->getErrorCode());
            //error_log('ERROR ' . $e->getCategory() . ': ' . $e->getMessage(), 0);
            $response = [
                'status' => 'error',
                'error' => $e->getMessage(),
                'code' => $e->getErrorCode(),
            ];
        }

        return $response;
    }

 
}