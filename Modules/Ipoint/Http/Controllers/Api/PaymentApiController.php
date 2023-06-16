<?php

namespace Modules\Ipoint\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Http\Controllers\Api\OrderApiController;
// Base Api
use Modules\Icommerce\Http\Controllers\Api\TransactionApiController;
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Repositories\TransactionRepository;
// Repositories
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Ipoint\Http\Requests\InitRequest;
use Modules\Ipoint\Repositories\PointRepository;

class PaymentApiController extends BaseApiController
{
    private $order;

    private $orderController;

    private $transaction;

    private $transactionController;

    private $paymentService;

    private $point;

    public function __construct(
        OrderRepository $order,
        OrderApiController $orderController,
        TransactionRepository $transaction,
        TransactionApiController $transactionController,
        PointRepository $point
    ) {
        $this->order = $order;
        $this->orderController = $orderController;
        $this->transaction = $transaction;
        $this->transactionController = $transactionController;
        $this->point = $point;
        $this->paymentService = app('Modules\Ipoint\Services\PaymentService');
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
            $paymentMethod = ipointGetConfiguration();
            $response = $this->point->calculate($request->all(), $paymentMethod->options);
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
     * @return route
     */
    public function init(Request $request)
    {
        try {
            $data = $request->all();

            $this->validateRequestApi(new InitRequest($data));

            $orderID = $request->orderId;

            // Payment Method Configuration
            $paymentMethod = ipointGetConfiguration();

            // Order
            $order = $this->order->find($orderID);
            $statusOrder = 1; // Processing

            // Validate minimum amount order
            if (isset($paymentMethod->options->minimunAmount) && $order->total < $paymentMethod->options->minimunAmount) {
                throw new \Exception(trans('icommerce::common.validation.minimumAmount').' :'.$paymentMethod->options->minimunAmount, 204);
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
            $eUrl = ipointEncriptUrl($order->id, $transaction->id);

            $redirectRoute = route('ipoint.payment.index', [$eUrl]);

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
     * Create Payment
     *
     * @param Requests encrp
     */
    public function processPayment(Request $request)
    {
        try {
            $data = $request['attributes'] ?? []; //Get data

            $paymentMethod = ipointGetConfiguration();

            $infor = ipointDecriptUrl($data['encrp']);

            $order = $this->order->find($infor[0]);
            $transactionId = $infor[1];

            \Log::info('Ipoint: PaymentApiController|processPayment|OrderID: '.$order->id);
            \Log::info('Ipoint: PaymentApiController|processPayment|TransactionID: '.$transactionId);

            // Process Payment Valid
            $authUser = \Auth::user();
            $resultValidate = $this->paymentService->validateProcessPayment($order->orderItems, $authUser->id);

            if ($resultValidate['processPayment']) {
                // Create a Point
                $data = [
                    'user_id' => $authUser->id,
                    'description' => 'Pago con Puntos - Orden #'.$order->id,
                    'points' => -$resultValidate['pointsItems'],
                ];
                $pointCreated = app("Modules\Ipoint\Services\PointService")->create($order, $data);

                //Updating Information
                $newStatusOrder = 13; //Processed
                $this->updateInformation($order->id, $transactionId, $newStatusOrder);

                // Extra infor
                $newTotalPoints = $resultValidate['pointsUser'] - $resultValidate['pointsItems'];

                // Result
                $dataResult['success'] = true;
                $dataResult['data'] = [
                    'newTotalPoints' => $newTotalPoints,
                ];
            }

            $response = $dataResult;
        } catch(\Exception $e) {
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
            \Log::error('Ipoint: PaymentApiController|processPayment|Message: '.$e->getMessage().' | FILE: '.$e->getFile().' | LINE: '.$e->getLine());
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Update Information
     */
    public function updateInformation($orderId, $transactionId, $newStatusOrder)
    {
        // Update Transaction
        $transaction = $this->validateResponseApi(
            $this->transactionController->update($transactionId, new Request([
                'status' => $newStatusOrder,
            ]))
        );

        // Update Order Process
        $orderUP = $this->validateResponseApi(
            $this->orderController->update($orderId, new Request(
                ['attributes' => [
                    'status_id' => $newStatusOrder,
                ],
                ]))
        );

        \Log::info('Ipoint: PaymentApiController|updateInformation|FINISHED');
    }
}
