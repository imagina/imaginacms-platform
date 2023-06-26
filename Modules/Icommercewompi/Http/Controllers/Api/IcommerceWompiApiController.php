<?php

namespace Modules\Icommercewompi\Http\Controllers\Api;

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
use Modules\Icommercewompi\Http\Requests\InitRequest;
use Modules\Icommercewompi\Repositories\IcommerceWompiRepository;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class IcommerceWompiApiController extends BaseApiController
{
    private $icommercewompi;

    private $paymentMethod;

    private $order;

    private $orderController;

    private $transaction;

    private $transactionController;

    public function __construct(

        IcommerceWompiRepository $icommercewompi,
        PaymentMethodRepository $paymentMethod,
        OrderRepository $order,
        OrderApiController $orderController,
        TransactionRepository $transaction,
        TransactionApiController $transactionController
    ) {
        $this->icommercewompi = $icommercewompi;
        $this->paymentMethod = $paymentMethod;
        $this->order = $order;
        $this->orderController = $orderController;
        $this->transaction = $transaction;
        $this->transactionController = $transactionController;
    }

    /**
     * Init Calculations
     *
     * @param Requests request
     * @return mixed
     */
    public function calculations(Request $request)
    {
        try {
            // Configuration
            $paymentName = config('asgard.icommercewompi.config.paymentName');
            $attribute = ['name' => $paymentName];
            $paymentMethod = $this->paymentMethod->findByAttributes($attribute);
            $response = $this->icommercewompi->calculate($request->all(), $paymentMethod->options);
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
     * @param Requests orderId
     */
    public function init(Request $request): route
    {
        try {
            $data = $request->all();

            $this->validateRequestApi(new InitRequest($data));

            $orderID = $request->orderId;
            //\Log::info('Module Icommercewompi: Init-ID:'.$orderID);

            // Payment Method Configuration
            $paymentMethod = icommercewompi_getPaymentMethodConfiguration();

            // Order
            $order = $this->order->find($orderID);
            $statusOrder = 1; // Processing

            // Validate minimum amount order
            if (isset($paymentMethod->options->minimunAmount) && $order->total < $paymentMethod->options->minimunAmount) {
                throw new \Exception(trans('icommercewompi::icommercewompis.messages.minimum').' :'.$paymentMethod->options->minimunAmount, 204);
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
            $eUrl = icommercewompi_encriptUrl($order->id, $transaction->id);

            $redirectRoute = route('icommercewompi', [$eUrl]);

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
     * Response Api Method - Confirmation
     *
     * @param Requests request
     */
    public function confirmation(Request $request): route
    {
        \Log::info('Module Icommercewompi: Confirmation - INIT - '.time());
        //\Log::info('Module Icommercewompi: Event: '.$request->event);
        //\Log::info('Module Icommercewompi: Data: '.json_encode($request->data));
        $response = ['msj' => 'Proceso Valido'];

        try {
            if ($request->event == 'transaction.updated') {
                $dataTransaction = $request->data['transaction'];
                //\Log::info('Module Icommercewompi: Transaction: '.json_encode($dataTransaction))

                // Get order id and transaction id from request
                $inforReference = icommercewompi_getInforRefCommerce($dataTransaction['reference']);

                $order = $this->order->find($inforReference['orderId']);
                \Log::info('Module Icommercewompi: Order Status Id: '.$order->status_id);

                // Status Order 'pending'
                if ($order->status_id == 1) {
                    // Wompi Service
                    $wompiService = app("Modules\Icommercewompi\Services\WompiService");

                    // Get Payment Method Configuration
                    $paymentMethod = icommercewompi_getPaymentMethodConfiguration();

                    // Default Status Order
                    $newStatusOrder = 7; // Status Order Failed

                    // Get States From Commerce
                    $codTransactionState = '';
                    $transactionState = $dataTransaction['status'];

                    // Get Signatures
                    $signature = $wompiService->makeSignature($request, $paymentMethod);
                    $x_signature = $request->signature['checksum'];

                    // Check signatures
                    if ($x_signature == $signature) {
                        $newStatusOrder = $wompiService->getStatusOrder($dataTransaction['status']);
                    } else {
                        $codTransactionState = 'Error - Sign';
                        \Log::info('Module Icommercewompi: **ERROR** en Firma');
                    }

                    // Update Transaction
                    $transaction = $this->validateResponseApi(
                        $this->transactionController->update($inforReference['transactionId'], new Request(
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
                }
            }

            \Log::info('Module Icommercewompi: Confirmation - END');
        } catch (\Exception $e) {
            //Log Error
            \Log::error('Module Icommercewompi: Message: '.$e->getMessage());
            \Log::error('Module Icommercewompi: Code: '.$e->getCode());
        }

        return response()->json($response, $status ?? 200);
    }
}
