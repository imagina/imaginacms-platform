<?php

namespace Modules\Icommercepayu\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Icommerce\Http\Controllers\Api\OrderApiController;
use Modules\Icommerce\Http\Controllers\Api\TransactionApiController;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Repositories
use Modules\Icommercepayu\Repositories\IcommercePayuRepository;

use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Repositories\TransactionRepository;
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Repositories\CurrencyRepository;


class IcommercePayuApiController extends BaseApiController
{

    private $icommercepayu;
    private $paymentMethod;
    private $order;
    private $orderController;
    private $transaction;
    private $transactionController;
    private $currency;

    public function __construct(

        IcommercePayuRepository $icommercepayu,
        PaymentMethodRepository $paymentMethod,
        OrderRepository $order,
        OrderApiController $orderController,
        TransactionRepository $transaction,
        TransactionApiController $transactionController,
        CurrencyRepository $currency
    ){
        $this->icommercepayu = $icommercepayu;
        $this->paymentMethod = $paymentMethod;
        $this->order = $order;
        $this->orderController = $orderController;
        $this->transaction = $transaction;
        $this->transactionController = $transactionController;
        $this->currency = $currency;

    }

    /**
     * Init data
     * @param Requests request
     * @param Requests orderID
     * @return route
     */
    public function init(Request $request){


        try {

            $orderID = $request->orderID;
            \Log::info('Icommercepayu: Init|orderID:'.$orderID);

            $paymentName = config('asgard.icommercepayu.config.paymentName');

            // Configuration
            $attribute = array('name' => $paymentName);
            $paymentMethod = $this->paymentMethod->findByAttributes($attribute);

            // Order
            $order = $this->order->find($orderID);
            $statusOrder = 1; // Processing

            // Validate minimum amount order
            if(isset($paymentMethod->options->minimunAmount) && $order->total<$paymentMethod->options->minimunAmount)
              throw new \Exception(trans("icommercepayu::icommercepayus.messages.minimum")." :".$paymentMethod->options->minimunAmount, 204);

            // get currency active
            //$currency = $this->currency->getActive();
            $currency = $order->currency_code;

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
            $eUrl = $this->icommercepayu->encriptUrl($order->id,$transaction->id,$currency);

            $redirectRoute = route('icommercepayu',[$eUrl]);

            // Response
            $response = [ 'data' => [
                "redirectRoute" => $redirectRoute,
                "external" => true
            ]];
            
            \Log::info('Icommercepayu: Init|Finished');

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
     * Response Api Method
     * @param Requests request
     * @return route
     */
    public function response(Request $request){

      try {

        \Log::info('Icommercepayu: Response|time: '.time());

        // Configuration
        $paymentName = config('asgard.icommercepayu.config.paymentName');
        $attribute = array('name' => $paymentName);
        $paymentMethod = $this->paymentMethod->findByAttributes($attribute);

        // Get IDS
        $referenceSale = explode('-',$request->reference_sale);
        $orderID = $referenceSale[0];
        $transactionID = $referenceSale[1];

        \Log::info('Icommercepayu: Response|orderID:'.$orderID);

        // Order
        $order = $this->order->find($orderID);

        \Log::info('Icommercepayu: Response|OrderStatusId '.$order->status_id);

        // Status Order 'Proccesing'
        if($order->status_id==1){

          \Log::info('Icommercepayu: Response|Actualizando orderID: '.$orderID);

          $signature = $this->icommercepayu->signatureGeneration($paymentMethod->options->apiKey,$request->merchant_id,$request->reference_sale,$request->value,$request->currency,$request->state_pol);

          $transactionState = $request->state_pol;
          $polResponseCode = $request->response_code_pol;

          if (strtoupper($signature) == strtoupper($request->sign)) {

                    if($transactionState == 6 && $polResponseCode == 5){

                        $newstatusOrder = 7; // Status Order Failed

                    } else if($transactionState == 6 && $polResponseCode == 4){

                        $newstatusOrder = 8; // Status Order Refunded

                    } else if($transactionState == 12 && $polResponseCode == 9994){

                        $newstatusOrder = 11; // Status Order Pending

                    } else if($transactionState == 4 && $polResponseCode == 1){

                        $newstatusOrder = 13; // Status Order Processed

                    }else{

                        $newstatusOrder = 7; // Status Order Failed
                    }

          }else{

            $newstatusOrder = 7; // Status Order Failed

          }

          \Log::info('Icommercepayu: Response|New Status Order: '.$newstatusOrder);

          $external_status = $transactionState;
          $external_code = $polResponseCode;

          // Update Transaction
          $transaction = $this->validateResponseApi(
            $this->transactionController->update($transactionID,new Request(
              ["attributes" => [
                'order_id' => $order->id,
                'payment_method_id' => $paymentMethod->id,
                'amount' => $order->total,
                'status' => $newstatusOrder,
                'external_status' => $external_status,
                'external_code' => $external_code
              ]
              ]))
          );

          // Update Order Process
          $orderUP = $this->validateResponseApi(
            $this->orderController->update($order->id,new Request(
              ["attributes" =>[
                'order_id' => $order->id,
                'status_id' => $newstatusOrder
              ]
              ]))
          );

        } // End if Not Processed and Canceled

        \Log::info('Icommercepayu: Response|END');

      } catch (\Exception $e) {

        \Log::info('Icommercepayu: Response|Exception');

          // Get IDS
          $referenceSale = explode('-',$request->reference_sale);
          $orderID = $referenceSale[0];
          $transactionID = $referenceSale[1];

          if(!empty($transactionID)){

              $newstatusOrder = 3; // Canceled

              // Update Transaction
              $transactionUP = $this->validateResponseApi(
                  $this->transactionController->update($transactionID,new Request([
                    "attributes" => [
                        'status' => $newstatusOrder,
                        'external_status' => "canceled",
                        'external_code' => $e->getCode()
                    ]
                  ]))
              );

              // Update Order Process
              $orderUP = $this->validateResponseApi(
                  $this->orderController->update($orderID,new Request(
                    ["attributes" =>[
                      'status_id' => $newstatusOrder,
                    ]
                  ]))
              );
          }

          //Message Error
          $status = 500;

          $response = [
            'errors' => $e->getMessage(),
            'code' => $e->getCode()
          ];

          //Log Error
          \Log::error('Icommercepayu: Message: '.$e->getMessage());
          \Log::error('Icommercepayu: Code: '.$e->getCode());

      }

      return response('Recibido', 200);


  }

    /**
    * Init Calculations
    * @param Requests request
    * @return mixed
    */
    public function calculations(Request $request)
    {
      
      try {
        
        // Configuration
        $paymentName = config('asgard.icommercepayu.config.paymentName');
        $attribute = array('name' => $paymentName);
        $paymentMethod = $this->paymentMethod->findByAttributes($attribute);
        $response = $this->icommercepayu->calculate($request->all(), $paymentMethod->options);
        
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
