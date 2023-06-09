<?php

namespace Modules\Icommercepaypal\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Http\Controllers\Api\OrderApiController;
// Base Api
use Modules\Icommerce\Http\Controllers\Api\TransactionApiController;
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
// Repositories
use Modules\Icommerce\Repositories\TransactionRepository;
use Modules\Icommercepaypal\Entities\Paypal;
use Modules\Icommercepaypal\Http\Requests\InitRequest;
use Modules\Icommercepaypal\Repositories\IcommercePaypalRepository;
// Entities
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class IcommercePaypalApiController extends BaseApiController
{
    private $icommercepaypal;

    private $paymentMethod;

    private $order;

    private $orderController;

    private $transaction;

    private $transactionController;

    private $currency;

    private $paypal;

    public function __construct(

        IcommercePaypalRepository $icommercepaypal,
        PaymentMethodRepository $paymentMethod,
        OrderRepository $order,
        OrderApiController $orderController,
        TransactionRepository $transaction,
        TransactionApiController $transactionController

    ) {
        $this->icommercepaypal = $icommercepaypal;
        $this->paymentMethod = $paymentMethod;
        $this->order = $order;
        $this->orderController = $orderController;
        $this->transaction = $transaction;
        $this->transactionController = $transactionController;
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
            $paymentMethod = icommercepaypal_getPaymentMethodConfiguration();
            $response = $this->icommercepaypal->calculate($request->all(), $paymentMethod->options);
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
     * Init data
     *
     * @param Requests request
     * @param Requests orderID
     * @return route
     */
    public function init(Request $request): route
    {
        try {
            $data = $request->all();

            $this->validateRequestApi(new InitRequest($data));

            $orderID = $request->orderId;

            // Payment Method Configuration
            $paymentMethod = icommercepaypal_getPaymentMethodConfiguration();

            // Order
            $order = $this->order->find($orderID);
            $statusOrder = 1; // Processing

            // Validate minimum amount order
            if (isset($paymentMethod->options->minimunAmount) && $order->total < $paymentMethod->options->minimunAmount) {
                throw new \Exception(trans('icommercepaypal::icommercepaypals.messages.minimum').' :'.$paymentMethod->options->minimunAmount, 204);
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

            // Init Paypal
            $this->paypal = new Paypal($paymentMethod);

            // Generate Payment
            $payment = $this->paypal->generatePayment($order, $transaction);

            // Get Url
            $redirectRoute = $payment->getApprovalLink();

            // Response
            $response = ['data' => [
                'redirectRoute' => $redirectRoute,
                'external' => true,
            ]];
        } catch (\PayPal\Exception\PayPalConnectionException $e) {
            \Log::error($e->getData());

            $status = 500;
            $response = [
                'errors' => json_decode($e->getData()),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Confirmation
     *
     * @param Requests request
     * @param Requests orderID
     */
    public function confirmation(Request $request, $order, $transactionId)
    {
        \Log::info('Module Icommercepaypal: Confirmation - INIT - '.time());

        try {
            // Payment Method Configuration
            $paymentMethod = icommercepaypal_getPaymentMethodConfiguration();

             // Default Status Order
            $newStatusOrder = 7; // Status Order Failed
            $codTransactionState = '';
            $transactionState = '';

            if (isset($request->paymentId) && isset($request->PayerID)) {
                // Init Paypal
                $paypal = new Paypal($paymentMethod);

                // Get Payment Infor
                $payment = $paypal->getPaymentInfor($request->paymentId, $request->PayerID);

                // Check State
                if ($payment->getState() === 'approved') {
                    $newStatusOrder = 13; //processed
                }

                // Get States From Commerce
                $transactionState = $payment->getState();
            } else {
                $newStatusOrder = 3; // Status Order Canceled
                $transactionState = 'canceled';
            }

            \Log::info('Module Icommercepaypal: New Status: '.$newStatusOrder);

            // Update Transaction
            $transaction = $this->validateResponseApi(
                $this->transactionController->update($transactionId, new Request(
                    ['attributes' => [
                        'order_id' => $order->id,
                        'payment_method_id' => $paymentMethod->id,
                        'amount' => $order->total,
                        'status' => $newStatusOrder,
                        'external_status' => $transactionState,
                        'external_code' => $codTransactionState,
                    ],
                    ]))
            );

            // Update Order Process
            $orderUP = $this->validateResponseApi(
                $this->orderController->update($order->id, new Request(
                    ['attributes' => [
                        'order_id' => $order->id,
                        'status_id' => $newStatusOrder,
                    ],
                    ]))
            );
        } catch (\Exception $e) {
            //Log Error
            \Log::error('Module Icommercepaypal-Confirmation: Message: '.$e->getMessage());
            \Log::error('Module Icommercepaypal-Confirmation: Code: '.$e->getCode());
        }

        \Log::info('Module Icommercepaypal: Confirmation - END');
    }
}
