<?php

namespace Modules\Icommercepaymentez\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
//Request
use Modules\Icommerce\Entities\Transaction as TransEnti;
// Base Api
use Modules\Icommerce\Http\Controllers\Api\OrderApiController;
use Modules\Icommerce\Http\Controllers\Api\TransactionApiController;
use Modules\Icommerce\Repositories\OrderRepository;
// Repositories Icommerce
use Modules\Icommerce\Repositories\TransactionRepository;
use Modules\Icommercepaymentez\Http\Requests\InitRequest;
use Modules\Icommercepaymentez\Repositories\IcommercePaymentezRepository;
use Modules\Icommercepaymentez\Services\PaymentezService;
// Services
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class IcommercePaymentezApiController extends BaseApiController
{
    private $icommercepaymentez;

    private $order;

    private $orderController;

    private $transaction;

    private $transactionController;

    private $paymentezService;

    private $paymentezApi;

    public function __construct(
        IcommercePaymentezRepository $icommercepaymentez,
        OrderRepository $order,
        OrderApiController $orderController,
        TransactionRepository $transaction,
        TransactionApiController $transactionController,
        PaymentezService $paymentezService,
        PaymentezApiController $paymentezApi
    ) {
        $this->icommercepaymentez = $icommercepaymentez;

        $this->order = $order;
        $this->orderController = $orderController;
        $this->transaction = $transaction;
        $this->transactionController = $transactionController;
        $this->paymentezService = $paymentezService;
        $this->paymentezApi = $paymentezApi;
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
            $paymentMethod = paymentezGetConfiguration();
            $response = $this->icommercepaymentez->calculate($request->all(), $paymentMethod->options);
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
            \Log::info('Icommercepaymentez: Init');

            $data = $request->all();

            $this->validateRequestApi(new InitRequest($data));

            $orderID = $request->orderId;
            //\Log::info('Module Icommercepaymentez: Init-ID:'.$orderID);

            // Payment Method Configuration
            $paymentMethod = paymentezGetConfiguration();

            // Order
            $order = $this->order->find($orderID);
            $statusOrder = 1; // Processing

            // Validate minimum amount order
            if (isset($paymentMethod->options->minimunAmount) && $order->total < $paymentMethod->options->minimunAmount) {
                throw new \Exception(trans('icommercepaymentez::icommercepaymentezs.messages.minimum').' :'.$paymentMethod->options->minimunAmount, 204);
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

            if ($paymentMethod->options->type == 'checkout') {
                // Encri
                $eUrl = paymentezEncriptUrl($order->id, $transaction->id);
                $redirectRoute = route('icommercepaymentez', [$eUrl]);
            } else {
                $redirectRoute = $this->paymentezApi->generateLink($paymentMethod, $order);
            }

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
     * Response
     *
     * @param Requests request
     */
    public function response(Request $request)
    {
        \Log::info('Icommercepaymentez: Response - INIT - '.time());

        $data = $request['transaction'];

        $response = ['status' => 'success'];

        try {
            // Order Id
            $orderId = $data['dev_reference'];
            $order = $this->order->find($orderId);

            \Log::info('Icommercepaymentez: Order Id: '.$orderId);
            \Log::info('Icommercepaymentez: Order Status Id: '.$order->status_id);

            $transactionId = TransEnti::where('order_id', $orderId)->latest()->first()->id;

            // Status Order 'processing' or pending
            if ($order->status_id == 1 || $order->status_id == 11) {
                // Payment Method Configuration
                $paymentMethod = paymentezGetConfiguration();

                // Implementation is not type checkout
                if ($paymentMethod->options->type != 'checkout') {
                    // Generate Stoken
                    $generateStoken = $this->paymentezService->generateStoken($data, $request['user'], $paymentMethod);

                    // Check signature
                    if ($generateStoken != $data['stoken']) {
                        throw new \Exception('Icommercepaymentez - ERROR INVALID STOKEN', 204);
                    }
                }

                // Get all infor about status
                $allNewStatus = $this->paymentezService->getStatusDetail($data['status_detail']);

                $externalCode = $data['id']; //Transaction ID Paymentez

                // Update Transaction
                $transaction = $this->validateResponseApi(
                    $this->transactionController->update($transactionId, new Request([
                        'status' => $allNewStatus['order'],
                        'external_status' => $allNewStatus['detail'],
                        'external_code' => $externalCode,
                    ]))
                );

                // Update Order Process
                $orderUP = $this->validateResponseApi(
                    $this->orderController->update($orderId, new Request(
                        ['attributes' => [
                            'status_id' => $allNewStatus['order'],
                        ],
                        ]))
                );
            }

            \Log::info('Icommercepaymentez: Response - END');
        } catch (\Exception $e) {
            //Log Error
            \Log::error('Icommercepaymentez: Message: '.$e->getMessage());
            \Log::error('Icommercepaymentez: Code: '.$e->getCode());

            //Message Error
            $status = 500;
            $response = [
                'status' => 'error',
                'errors' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }
}
