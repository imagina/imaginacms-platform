<?php

namespace Modules\Icommerceopenpay\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
//Request
use Modules\Icommerce\Http\Controllers\Api\OrderApiController;
// Base Api
use Modules\Icommerce\Http\Controllers\Api\TransactionApiController;
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Repositories\TransactionRepository;
// Repositories
use Modules\Icommerceopenpay\Http\Requests\InitRequest;
use Modules\Icommerceopenpay\Repositories\IcommerceOpenpayRepository;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class IcommerceOpenpayApiController extends BaseApiController
{
    private $icommerceopenpay;

    private $order;

    private $orderController;

    private $transaction;

    private $transactionController;

    private $openpayApi;

    private $openpayService;

    public function __construct(
        IcommerceOpenpayRepository $icommerceopenpay,
        OrderRepository $order,
        OrderApiController $orderController,
        TransactionRepository $transaction,
        TransactionApiController $transactionController,
        OpenpayApiController $openpayApi
    ) {
        $this->icommerceopenpay = $icommerceopenpay;
        $this->order = $order;
        $this->orderController = $orderController;
        $this->transaction = $transaction;
        $this->transactionController = $transactionController;
        $this->openpayApi = $openpayApi;
        $this->openpayService = app("Modules\Icommerceopenpay\Services\OpenpayService");
    }

    /**
     * Init Calculations (Validations to checkout)
     *
     * @param Requests request
     * @return mixed
     */
    public function calculations(Request $request)
    {
        try {
            $paymentMethod = openpayGetConfiguration();
            $response = $this->icommerceopenpay->calculate($request->all(), $paymentMethod->options);
        } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * ROUTE - Init data
     *
     * @param Requests request
     * @param Requests orderId
     */
    public function init(Request $request)
    {
        try {
            $data = $request->all();

            $this->validateRequestApi(new InitRequest($data));

            $orderID = $request->orderId;
            //\Log::info('Module Icommerceopenpay: Init-ID:'.$orderID);

            // Payment Method Configuration
            $paymentMethod = openpayGetConfiguration();

            // Order
            $order = $this->order->find($orderID);
            $statusOrder = 1; // Processing

            // Validate minimum amount order
            if (isset($paymentMethod->options->minimunAmount) && $order->total < $paymentMethod->options->minimunAmount) {
                throw new \Exception(trans('icommerceopenpay::icommerceopenpays.messages.minimum').' :'.$paymentMethod->options->minimunAmount, 204);
            }

            // Create Transaction
            $transaction = $this->validateResponseApi(
                $this->transactionController->create(new Request(['attributes' => [
                    'order_id' => $order->id,
                    'payment_method_id' => $paymentMethod->id,
                    'amount' => $order->total,
                    'status' => $statusOrder,
                ]]))
            );

            // Encri
            $eUrl = openpayEncriptUrl($order->id, $transaction->id);

            $redirectRoute = route('icommerceopenpay', [$eUrl]);

            // Response
            $response = ['data' => [
                'redirectRoute' => $redirectRoute,
                'external' => true,
            ]];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * ROUTE - POST Process Payment - Credit and Debits Cards
     *
     * @param OrderId
     * @param clientToken
     * @param deviceId
     */
    public function processPayment(Request $request)
    {
        \Log::info('Icommerceopenpay: processPayment');

        try {
            $data = $request['attributes'] ?? []; //Get data

            $orderId = $data['orderId'];
            $transactionId = $data['transactionId'];

            // Validate Exist Order Id
            $order = $this->order->find($orderId);
            \Log::info('Icommerceopenpay: OrderID: '.$order->id);

            // Validate that the transaction is associated with the order
            $transaction = $order->transactions->find($transactionId);
            \Log::info('Icommerceopenpay: transactionID: '.$transaction->id);

            $response = $this->openpayApi->createCharge($order, $transaction, $data['clientToken'], $data['deviceId']);
        } catch(\Exception $e) {
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
            \Log::error('Icommerceopenpay: processPayment|Message: '.$e->getMessage());
            \Log::error('Icommerceopenpay: processPayment|Code: '.$e->getCode());
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * ROUTE - POST Process Payment PSE
     *
     * @param OrderId
     */
    public function processPaymentPse(Request $request)
    {
        \Log::info('Icommerceopenpay: processPaymentPse');

        try {
            $data = $request['attributes'] ?? []; //Get data

            $orderId = $data['orderId'];
            $transactionId = $data['transactionId'];

            // Validate exist Order Id and transaction Id
            $order = $this->order->find($orderId);
            $transaction = $order->transactions->find($transactionId);

            // create pse request
            $response = $this->openpayApi->createPseRequest($order, $transaction);
        } catch(\Exception $e) {
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
            \Log::error('Icommerceopenpay: processPaymentPse|Message: '.$e->getMessage());
            \Log::error('Icommerceopenpay: processPaymentPse|Code: '.$e->getCode());
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Confirmation response - After payment
     *
     * @param Requests request
     */
    public function confirmation(Request $request)
    {
        \Log::info('IcommerceOpenpay: CONFIRMATION|requestType: '.$request->type);

        $response = ['msj' => 'Proceso Valido'];

        if ($request->type == 'verification') {
            // Payment Method Configuration
            $paymentMethod = openpayGetConfiguration();

            $this->openpayService->saveVerificationCode($request, $paymentMethod);
        } else {
            try {
                // Get transaction Openpay
                $t = json_decode(json_encode($request->transaction));

                //Get order id and transaction id from request
                $inforReference = openpayGetInforRefCommerce($t->order_id);

                // Validate exist Order Id and transaction Id
                $order = $this->order->find($inforReference['orderId']);
                $transaction = $order->transactions->find($inforReference['transactionId']);

                \Log::info('Icommerceopenpay: confirmation|OrderId: '.$order->id);

                // Status Order 'pending'
                if ($order->status_id == 1) {
                    $newStatusOrder = $this->openpayService->getStatusOrder($request->type);

                    /*
                    * Openpay envia 1 notificacion cuando se crea algo, por lo tanto el
                    estatus es como si estuviese "pendiente", para no repetir el mismo status en el historial de la orden se valida que el nuevo estatus se diferente a pendiente
                    */
                    if ($newStatusOrder != 1) {
                        $this->updateInformation($inforReference['orderId'], $inforReference['transactionId'], $newStatusOrder, ['code' => $t->status, 'error' => $t->error_message]);
                    }
                }
            } catch (\Exception $e) {
                //Log Error
                \Log::error('IcommerceOpenpay: confirmation|Message: '.$e->getMessage());
                \Log::error('IcommerceOpenpay: confirmation|Code: '.$e->getCode());
            }
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Update Information
     */
    public function updateInformation($orderId, $transactionId, $newStatusOrder, $response = null)
    {
        \Log::info('Icommerceopenpay: updateInformation');

        $externalStatus = $response['error'] ?? '';
        $externalCode = $response['code'] ?? '';

        \Log::info('Icommerceopenpay: updateInformation|externalCode: '.$externalCode);
        \Log::info('Icommerceopenpay: updateInformation|externalStatus: '.$externalStatus);

        // Update Transaction
        $transaction = $this->validateResponseApi(
            $this->transactionController->update($transactionId, new Request([
                'status' => $newStatusOrder,
                'external_status' => $externalStatus,
                'external_code' => $externalCode,
            ]))
        );

        // Update Order
        $orderUP = $this->validateResponseApi(
            $this->orderController->update($orderId, new Request(
                ['attributes' => [
                    'status_id' => $newStatusOrder,
                    'comment' => trans('icommerce::orders.messages.order updated by', ['paymentMethod' => 'Openpay']),
                ],
                ]))
        );
    }
}
