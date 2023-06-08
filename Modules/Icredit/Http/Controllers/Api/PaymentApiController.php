<?php

namespace Modules\Icredit\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Modules\Icredit\Http\Requests\InitRequest;

// Base Api
use Modules\Icommerce\Http\Controllers\Api\OrderApiController;
use Modules\Icommerce\Http\Controllers\Api\TransactionApiController;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Repositories
use Modules\Icredit\Repositories\CreditRepository;

use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Repositories\TransactionRepository;
use Modules\Icommerce\Repositories\OrderRepository;

use Modules\Icommerce\Entities\Transaction as TransEnti;

class PaymentApiController extends BaseApiController
{

   
    private $order;
    private $orderController;
    private $transaction;
    private $transactionController;
    private $paymentService;
    private $credit;

    public function __construct(
        OrderRepository $order,
        OrderApiController $orderController,
        TransactionRepository $transaction,
        TransactionApiController $transactionController,
        CreditRepository $credit
    ){
        $this->order = $order;
        $this->orderController = $orderController;
        $this->transaction = $transaction;
        $this->transactionController = $transactionController;
        $this->credit = $credit;
        $this->paymentService = app('Modules\Icredit\Services\PaymentService');
    }


    /**
    * Init Calculations (Validations to checkout)
    * @param Requests request
    * @return mixed
    */
    public function calculations(Request $request)
    {
      
      try {

        $paymentMethod = icredit_getPaymentMethodConfiguration();
        $response = $this->credit->calculate($request->all(), $paymentMethod->options);
        
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
            
            // Payment Method Configuration
            $paymentMethod = icredit_getPaymentMethodConfiguration();

            // Order
            $order = $this->order->find($orderID);
            $statusOrder = 1; // Processing

            // Validate minimum amount order
            if(isset($paymentMethod->options->minimunAmount) && $order->total<$paymentMethod->options->minimunAmount)
              throw new \Exception(trans("icredit::credits.messages.minimum")." :".$paymentMethod->options->minimunAmount, 204);

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
            $eUrl = icredit_encriptUrl($order->id,$transaction->id);

            $redirectRoute = route('icredit.payment.index',[$eUrl]);

            // Response
            $response = [ 'data' => [
                  "redirectRoute" => $redirectRoute,
                  "external" => true
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
     * Create Payment
     * @param Requests encrp
     * @return 
     */
    public function processPayment(Request $request){

        try {

            $data = $request['attributes'] ?? [];//Get data
            
            $paymentMethod = icredit_getPaymentMethodConfiguration();
            
            $infor = icredit_DecriptUrl($data['encrp']);

            $order = $this->order->find($infor[0]);
            $transactionId = $infor[1];

            \Log::info('Icredit: processPayment|OrderID: '.$order->id);
            \Log::info('Icredit: processPayment|TransactionID: '.$transactionId);

            // Process Payment Valid
            $authUser = \Auth::user();
            $resultValidate = $this->paymentService->validateProcessPayment($authUser->id,$order->total);

            if($resultValidate['processPayment']){

                // Create a credit
                $data = [
                    'amount' => -$order->total,
                    'customerId' => $authUser->id,
                    'description' => 'Pago de Orden #'.$order->id,
                    'status' => 2,
                    'relatedId' => $order->id,
                    'relatedType' => get_class($order)
                ];
                $creditCreated = app("Modules\Icredit\Services\CreditService")->create($data);

                //Updating Information
                $newStatusOrder = 13; //Processed
                $this->updateInformation($order->id,$transactionId,$newStatusOrder);

                // Extra infor
                $newTotalCredit = $resultValidate['creditUser'] - $order->total;  

                $dataResult["success"] = true;
                $dataResult["data"] = [
                    "newTotalCredit" => $newTotalCredit
                ];
            }
           
            $response = $dataResult;

        }catch(\Exception $e){
            $status = 500;
            $response = [
              'errors' => $e->getMessage()
            ];
            \Log::error('Icredit: PaymentApiController|processPayment|Message: '.$e->getMessage().' | FILE: '.$e->getFile().' | LINE: '.$e->getLine());
        }

        return response()->json($response, $status ?? 200);
    }

    /**
    * Update Information
    */
    public function updateInformation($orderId,$transactionId,$newStatusOrder){

        
        // Update Transaction
        $transaction = $this->validateResponseApi(
            $this->transactionController->update($transactionId,new Request([
                'status' => $newStatusOrder
            ]))
        );

        // Update Order Process
        $orderUP = $this->validateResponseApi(
            $this->orderController->update($orderId,new Request(
                ["attributes" =>[
                    'status_id' => $newStatusOrder
                ]
            ]))
        );

        \Log::info('Module Icredit: update Information: FINISHED');

    }



   

   
}