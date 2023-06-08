<?php

namespace Modules\Icommerceepayco\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Modules\Icommerceepayco\Http\Requests\InitRequest;

// Base Api
use Modules\Icommerce\Http\Controllers\Api\OrderApiController;
use Modules\Icommerce\Http\Controllers\Api\TransactionApiController;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Repositories
use Modules\Icommerceepayco\Repositories\IcommerceEpaycoRepository;

use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Repositories\TransactionRepository;
use Modules\Icommerce\Repositories\OrderRepository;


class IcommerceEpaycoApiController extends BaseApiController
{

    private $icommerceepayco;
    private $paymentMethod;
    private $order;
    private $orderController;
    private $transaction;
    private $transactionController;

    public function __construct(

        IcommerceEpaycoRepository $icommerceepayco,
        PaymentMethodRepository $paymentMethod,
        OrderRepository $order,
        OrderApiController $orderController,
        TransactionRepository $transaction,
        TransactionApiController $transactionController
    ){
        $this->icommerceepayco = $icommerceepayco;
        $this->paymentMethod = $paymentMethod;
        $this->order = $order;
        $this->orderController = $orderController;
        $this->transaction = $transaction;
        $this->transactionController = $transactionController;
    }


    /**
    * Init Calculations (Validations to checkout)
    * @param Requests request
    * @return mixed
    */
    public function calculations(Request $request)
    {

      try {

        $paymentMethod = icommerceepayco_getPaymentMethodConfiguration();
        $response = $this->icommerceepayco->calculate($request->all(), $paymentMethod->options);

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
     * Init data
     * @param Requests request
     * @param Requests orderId
     * @return route
     */
    public function init(Request $request){

        try {
  
          $data = $request->all();
           
          $this->validateRequestApi(new InitRequest($data));

          $orderID = $request->orderId;
          //\Log::info('Module Icommerceepayco: Init-ID:'.$orderID);

          // Payment Method Configuration
          $paymentMethod = icommerceepayco_getPaymentMethodConfiguration();

          // Order
          $order = $this->order->find($orderID);
          $statusOrder = 1; // Processing

            // Validate minimum amount order
          if(isset($paymentMethod->options->minimunAmount) && $order->total<$paymentMethod->options->minimunAmount)
              throw new \Exception(trans("icommerceepayco::icommerceepaycos.messages.minimum")." :".$paymentMethod->options->minimunAmount, 204);

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
          $eUrl = icommerceepayco_encriptUrl($order->id,$transaction->id);

          $redirectRoute = route('icommerceepayco',[$eUrl]);

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
     * Response Api Method
     * @param Requests request
     * @return route
     */
    public function confirmation(Request $request){

        \Log::info('Module Icommerceepayco: Confirmation - INIT - '.time());
        \Log::info('Module Icommerceepayco: id_invoice: '.$request->x_id_invoice);
        $response = ['msj' => "Proceso Valido"];

        try {

          // Get order id and transaction id from request
          $inforReference = icommerceepayco_getInforRefCommerce($request->x_id_invoice);

          $order = $this->order->find($inforReference['orderId']);
          \Log::info('Module Icommerceepayco: Order Status Id: '.$order->status_id );
         
          // Status Order 'pending'
          if($order->status_id==1){

            // Epayco Service
            $epaycoService = app("Modules\Icommerceepayco\Services\EpaycoService");

            // Show Vars Log - Just Testing
            //$epaycoService->showVarsLog($request);

            // Payment Method Configuration
            $paymentMethod = icommerceepayco_getPaymentMethodConfiguration();

            // Get Signatures
            $signature = $epaycoService->makeSignature($request,$paymentMethod);
            $x_signature = $request->x_signature;

            // Default Status Order
            $newStatusOrder = 7; // Status Order Failed

            // Get States From Commerce
            $codTransactionState = $request->x_cod_transaction_state;
            $transactionState = $request->x_transaction_state;

            // Check signature
            if ($x_signature == $signature) 
              $newStatusOrder =  $epaycoService->getStatusOrder($codTransactionState);
            else
              \Log::info('Module Icommerceepayco: **ERROR** en Firma');
           

            // Update Transaction
            $transaction = $this->validateResponseApi(
                $this->transactionController->update($inforReference['transactionId'],new Request(
                    ["attributes" => [
                        'order_id' => $order->id,
                        'payment_method_id' => $paymentMethod->id,
                        'amount' => $order->total,
                        'status' => $newStatusOrder,
                        'external_status' => $transactionState,
                        'external_code' => $codTransactionState
                    ]
                ]))
            );

            // Update Order Process
            $orderUP = $this->validateResponseApi(
                $this->orderController->update($order->id,new Request(
                  ["attributes" =>[
                    'order_id' => $order->id,
                    'status_id' => $newStatusOrder
                  ]
                ]))
            );

          }


          \Log::info('Module Icommerceepayco: Confirmation - END');

        } catch (\Exception $e) {

            //Log Error
            \Log::error('Module Icommerceepayco: Message: '.$e->getMessage());
            \Log::error('Module Icommerceepayco: Code: '.$e->getCode());

        }


        return response()->json($response, $status ?? 200);

    }

   
}