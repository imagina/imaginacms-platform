<?php

namespace Modules\Icommercebraintree\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Modules\Icommercebraintree\Http\Requests\InitRequest;

// Base Api
use Modules\Icommerce\Http\Controllers\Api\OrderApiController;
use Modules\Icommerce\Http\Controllers\Api\TransactionApiController;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

use Modules\Icommercebraintree\Http\Controllers\Api\BraintreeApiController;

// Repositories
use Modules\Icommercebraintree\Repositories\IcommerceBraintreeRepository;

use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Repositories\TransactionRepository;
use Modules\Icommerce\Repositories\OrderRepository;

use Modules\Icommerce\Entities\Transaction as TransEnti;

class IcommerceBraintreeApiController extends BaseApiController
{

    private $icommercebraintree;
    private $paymentMethod;
    private $order;
    private $orderController;
    private $transaction;
    private $transactionController;

    private $braintreeApi;

    public function __construct(
        IcommerceBraintreeRepository $icommerceebraintree,
        PaymentMethodRepository $paymentMethod,
        OrderRepository $order,
        OrderApiController $orderController,
        TransactionRepository $transaction,
        TransactionApiController $transactionController,
        BraintreeApiController $braintreeApi
    ){
        $this->icommerceebraintree = $icommerceebraintree;
        $this->paymentMethod = $paymentMethod;
        $this->order = $order;
        $this->orderController = $orderController;
        $this->transaction = $transaction;
        $this->transactionController = $transactionController;
        $this->braintreeApi = $braintreeApi;
    }

    /**
     * ROUTE - Init data
     * @param Requests request
     * @param Requests orderId
     * @return route
     */
    public function init(Request $request){

        try {
  
            $data = $request->all();
           
            $this->validateRequestApi(new InitRequest($data));

            $orderID = $request->orderId;
            //\Log::info('Module Icommercebraintree: Init-ID:'.$orderID);

            // Payment Method Configuration
            $paymentMethod = braintree_getPaymentMethodConfiguration();

            // Order
            $order = $this->order->find($orderID);
            $statusOrder = 1; // Processing

            // Validate minimum amount order
            if(isset($paymentMethod->options->minimunAmount) && $order->total<$paymentMethod->options->minimunAmount)
              throw new \Exception(trans("icommercebraintree::icommercebraintrees.messages.minimum")." :".$paymentMethod->options->minimunAmount, 204);

            // Create Transaction
            $transaction = $this->validateResponseApi(
                $this->transactionController->create(new Request( ["attributes" => [
                    'order_id' => $order->id,
                    'payment_method_id' => $paymentMethod->id,
                    'amount' => $order->total,
                    'status' => $statusOrder
                ]]))
            );

            // Encri
            $eUrl = braintree_encriptUrl($order->id,$transaction->id);
        
            $redirectRoute = route('icommercebraintree',[$eUrl]);

            // Response
            $response = [ 'data' => [
                  "redirectRoute" => $redirectRoute,
                  "external" => false
            ]];


        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = 500;
            $response = [
                'errors' => $e->getMessage()
            ];
        }


        return response()->json($response, $status ?? 200);

    }


    /**
    * ROUTE - GET Client Token
    * @return Token
    */
    public function getClientToken(){

        try {

            $token = $this->braintreeApi->generateClientToken();
            
            $response = [ 'data' => [
                  "token" => $token
            ]];

        }catch(\Exception $e){
            $status = 500;
            $response = [
              'errors' => $e->getMessage()
            ];
            \Log::error('Module Icommercebraintree: Get Client Token - Message: '.$e->getMessage());
            \Log::error('Module Icommercebraintree: Get Client Token - Code: '.$e->getCode());
        }

        return response()->json($response, $status ?? 200);
    }

    /**
    * ROUTE - POST Process Payment
    * @param OrderId
    * @param nonce 
    * @return response
    */
    public function processPayment(Request $request){

        try {

            $data = $request['attributes'] ?? [];//Get data

            $orderId = $data['orderId'];
            $transactionId = TransEnti::where('order_id',$orderId)->latest()->first()->id;

            $order = $this->order->find($orderId);
            \Log::info('Icommercebraintree: processPayment - OrderID: '.$order->id);
            \Log::info('Icommercebraintree: processPayment - TransactionID: '.$transactionId);

            // Braintree Service
            $braintreeService = app("Modules\Icommercebraintree\Services\BraintreeService");

            $type = 1; //Transaction

            //Suscription Braintree
            if(isset($data['planId']) && !empty($data['planId'])){
                $result= $this->braintreeApi->createSuscription($order,$data);
                $type = 2;
            }else{

            //Transaction Braintree
                $result = $this->braintreeApi->createTransaction($order,$data['clientNonce']);   
            }

            // Success Response
            if($result->success) {
                
                // Transaction
                if($type==1)
                    $transactionBraintree = $result->transaction;
                else
                    $transactionBraintree = $result->subscription->transactions[0];

                // Get Status Order
                $newStatusOrder = $braintreeService->getStatusOrder($transactionBraintree->status);

                // Update Order and Transaction
                $this->updateInformation($order->id,$transactionId,$newStatusOrder,$transactionBraintree);

                // Response Result Transaction Braintree
                $response = [ 'data' => $result ];

            }else{

                // Failed
                $newStatusOrder = 7;

                // Get Errors Information from Result Braintree
                $errors = $braintreeService->getErrors($result->errors->deepAll());
                
                // Update Order and Transaction
                $this->updateInformation($order->id,$transactionId,$newStatusOrder,null,$errors);

                throw new \Exception($errors['string'], 204);

            }

        }catch(\Exception $e){
            $status = 500;
            $response = [
              'errors' => $e->getMessage()
            ];
            \Log::error('Module Icommercebraintree: Process Payment - Message: '.$e->getMessage());
            \Log::error('Module Icommercebraintree: Process Payment - Code: '.$e->getCode());
        }

        return response()->json($response, $status ?? 200);

    }

    /**
    * ROUTE - GET Transaction
    * @param Id Transaction Braintree
    * @return transaction
    */
    public function findTransaction($id){

        try {

            $transaction = $this->braintreeApi->getTransaction($id);
            
            $response = [ 'data' => [
                  "transaction" => $transaction
            ]];

        }catch(\Exception $e){
            $status = 500;
            $response = [
              'errors' => $e->getMessage()
            ];
            \Log::error('Module Icommercebraintree: Find Transaction - Message: '.$e->getMessage());
            \Log::error('Module Icommercebraintree: Find Transaction - Code: '.$e->getCode());
        }

        return response()->json($response, $status ?? 200);
    }


    /**
    * Update Information (Order and Transaction)
    */
    public function updateInformation($orderId,$transactionId,$newStatusOrder,
        $transactionBraintree=null,$errors=null){

        if(is_null($transactionBraintree)){
            $externalStatus = $errors['msj'];
            $externalCode = $errors['code'];
        }else{
            $externalStatus = $transactionBraintree->status;
            $externalCode = $transactionBraintree->id;
        }

        // Update Transaction
        $transaction = $this->validateResponseApi(
            $this->transactionController->update($transactionId,new Request([
                'status' => $newStatusOrder,
                'external_status' => $externalStatus,
                'external_code' => $externalCode
            ]))
        );

       
        $suscriptionId = null;
        if(isset($transactionBraintree->subscriptionId)){
            $suscriptionId = $transactionBraintree->subscriptionId;
            \Log::info('Module Icommercebraintree: SuscriptionId: '.$suscriptionId);
        }

        // Update Order Process
        $orderUP = $this->validateResponseApi(
            $this->orderController->update($orderId,new Request(
                ["attributes" =>[
                    'status_id' => $newStatusOrder,
                    'suscription_id' => $suscriptionId
                ]
            ]))
        );

    }


   
}