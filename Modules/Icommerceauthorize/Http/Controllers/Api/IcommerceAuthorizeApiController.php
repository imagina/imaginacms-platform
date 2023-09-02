<?php

namespace Modules\Icommerceauthorize\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// Base Api
use Modules\Icommerce\Http\Controllers\Api\OrderApiController;
use Modules\Icommerce\Http\Controllers\Api\TransactionApiController;
use Modules\Icommerce\Repositories\OrderRepository;
// Repositories
use Modules\Icommerce\Repositories\TransactionRepository;
use Modules\Icommerceauthorize\Http\Requests\InitRequest;
// Request
use Modules\Icommerceauthorize\Repositories\IcommerceAuthorizeRepository;
// Repositories
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class IcommerceAuthorizeApiController extends BaseApiController
{
    private $icommerceauthorize;

    private $order;

    private $orderController;

    private $transaction;

    private $transactionController;

    public function __construct(
        IcommerceAuthorizeRepository $icommerceauthorize,
        OrderRepository $order,
        OrderApiController $orderController,
        TransactionRepository $transaction,
        TransactionApiController $transactionController
    ) {
        $this->icommerceauthorize = $icommerceauthorize;
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
            $paymentMethod = authorize_getPaymentMethodConfiguration();
            $response = $this->icommerceauthorize->calculate($request->all(), $paymentMethod->options);
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
     * @param Requests orderid
     */
    public function init(Request $request)
    {
        try {
            $data = $request->all();

            $this->validateRequestApi(new InitRequest($data));

            $orderId = $request->orderId;
            //\Log::info('Module Icommerceauthorize: Init-ID:'.$orderID);

            // Payment Method Configuration
            $paymentMethod = authorize_getPaymentMethodConfiguration();

            // Order
            $order = $this->order->find($orderId);
            $statusOrder = 1; // Processing

            // Validate minimum amount order
            if (isset($paymentMethod->options->minimunAmount) && $order->total < $paymentMethod->options->minimunAmount) {
                throw new \Exception(trans('icommerceauthorize::icommerceauthorizes.messages.minimum').' :'.$paymentMethod->options->minimunAmount, 204);
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
            $eUrl = authorize_encriptUrl($order->id, $transaction->id);

            $redirectRoute = route('icommerceauthorize', [$eUrl]);

            // Response
            $response = ['data' => [
                'redirectRoute' => $redirectRoute,
                'external' => true,
            ]];
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
     * Response Api Method
     *
     * @param Requests request
     */
    public function response(Request $request)
    {
        try {
            \Log::info('Module Icommerceauthorize: Response - '.time());

            $response = $request->response;
            $orderID = $request->orderID;
            $transactionID = $request->transactionID;
            $paymentMethodID = $request->paymentMethodID;

            // Order
            $order = $this->order->find($orderID);

            if ($response != null) {
                // Check to see if the API request was successfully received and acted upon
                if ($response->getMessages()->getResultCode() == 'Ok') {
                    // Since the API request was successful, look for a transaction response
                    // and parse it to display the results of authorizing the card
                    $tresponse = $response->getTransactionResponse();

                    if ($tresponse != null && $tresponse->getMessages() != null) {
                        $newstatusOrder = 13; // Status Order Processed
                        $message = 'ok';
                    } else {
                        if ($tresponse->getErrors() != null) {
                            $message = ' Error Code  : '.$tresponse->getErrors()[0]->getErrorCode().'- Error Message : '.$tresponse->getErrors()[0]->getErrorText();
                            \Log::error($message);
                        }

                        $newstatusOrder = 7; // Status Order Failed
                    }
                // Or, print errors if the API request wasn't successful
                } else {
                    $tresponse = $response->getTransactionResponse();

                    if ($tresponse != null && $tresponse->getErrors() != null) {
                        $message = ' Error Code  : '.$tresponse->getErrors()[0]->getErrorCode().'- Error Message : '.$tresponse->getErrors()[0]->getErrorText();
                    } else {
                        $message = ' Error Code  : '.$response->getMessages()->getMessage()[0]->getCode().'- Error Message : '.$response->getMessages()->getMessage()[0]->getText();
                    }

                    \Log::error($message);
                    $newstatusOrder = 7; // Status Order Failed
                }
            } else {
                $message = 'Error - Response is NULL';
                \Log::error($message);
                $newstatusOrder = 7; // Status Order Failed
            }

            $external_status = $message;

            // Update Transaction
            $transaction = $this->validateResponseApi(
                $this->transactionController->update($transactionID, new Request(
                    ['attributes' => [
                        'order_id' => $order->id,
                        'payment_method_id' => $paymentMethodID,
                        'amount' => $order->total,
                        'status' => $newstatusOrder,
                        'external_status' => $external_status,
                    ],
                    ]))
            );

            // Update Order Process
            $orderUP = $this->validateResponseApi(
                $this->orderController->update($order->id, new Request(
                    ['attributes' => [
                        'order_id' => $order->id,
                        'status_id' => $newstatusOrder,
                    ],
                    ]))
            );

            // Response
            $response = ['data' => [
                'status' => 'success',
            ]];
        } catch (\Exception $e) {
            \Log::info('Module Icommerceauthorize: Exception - AuthorizeApiController');

            $orderID = $request->orderID;
            $transactionID = $request->transactionID;
            //$paymentMethodID = $request->paymentMethodID;

            if (! empty($transactionID)) {
                $newstatusOrder = 3; // Canceled

                // Update Transaction
                $transactionUP = $this->validateResponseApi(
                    $this->transactionController->update($transactionID, new Request(
                        ['attributes' => [
                            'status' => $newstatusOrder,
                            'external_status' => 'canceled',
                            'external_code' => $e->getCode(),
                        ],
                        ]))
                );

                // Update Order Process
                $orderUP = $this->validateResponseApi(
                    $this->orderController->update($orderID, new Request(
                        ['attributes' => [
                            'status_id' => $newstatusOrder,
                        ],
                        ]))
                );
            }

            //Message Error
            $status = 500;

            $response = [
                'errors' => $e->getMessage(),
                'code' => $e->getCode(),
            ];

            //Log Error
            \Log::error('Module Icommerceauthorize: Message: '.$e->getMessage());
            \Log::error('Module Icommerceauthorize: Code: '.$e->getCode());
        }

        return response()->json($response, $status ?? 200);
    }
}
