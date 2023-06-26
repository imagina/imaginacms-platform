<?php

namespace Modules\Icommercexpay\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Transaction as TransEnti;
// Base Api
use Modules\Icommerce\Http\Controllers\Api\OrderApiController;
use Modules\Icommerce\Http\Controllers\Api\OrderStatusHistoryApiController;
use Modules\Icommerce\Http\Controllers\Api\TransactionApiController;
use Modules\Icommerce\Repositories\OrderRepository;
// Repositories
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Repositories\TransactionRepository;
use Modules\Icommercexpay\Events\ResponseWasReceived;
use Modules\Icommercexpay\Http\Requests\InitRequest;
use Modules\Icommercexpay\Repositories\IcommerceXpayRepository;
// Events
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class IcommerceXpayApiController extends BaseApiController
{
    private $checkmo;

    private $paymentMethod;

    private $order;

    private $orderController;

    private $orderHistory;

    private $transaction;

    private $transactionController;

    const URL_PRODUCTION = 'https://xpay.cash';

    const URL_SANDBOX = 'https://test.xpay.cash';

    protected $urlsSandbox;

    public function __construct(
        IcommerceXpayRepository $checkmo,
        PaymentMethodRepository $paymentMethod,
        OrderRepository $order,
        OrderApiController $orderController,
        OrderStatusHistoryApiController $orderHistory,
        TransactionRepository $transaction,
        TransactionApiController $transactionController
    ) {
        $this->checkmo = $checkmo;
        $this->paymentMethod = $paymentMethod;
        $this->order = $order;
        $this->orderController = $orderController;
        $this->orderHistory = $orderHistory;
        $this->transaction = $transaction;
        $this->transactionController = $transactionController;

        $this->urls = [
            'getTokenLogin' => '/api/v1/auth/login/',
            'getAccountInformation' => '/api/v1/users/',
            'getCurrencies' => '/api/v1/transactions/available/currencies/',
            'createPayment' => '/api/v1/transactions/create/',
        ];
    }

    /**
     * Init data
     *
     * @param Requests orderid
     */
    public function init(Request $request): route
    {
        try {
            $data = $request->all();

            $this->validateRequestApi(new InitRequest($data));

            $orderID = $request->orderID;
            \Log::info('Module Icommercexpay: Init-ID:'.$orderID);

            $paymentMethod = $this->getPaymentMethodConfiguration();

            // Order
            $order = $this->order->find($orderID);
            $statusOrder = 1; // Processing

            // Validate minimum amount order
            if (isset($paymentMethod->options->minimunAmount) && $order->total < $paymentMethod->options->minimunAmount) {
                throw new \Exception('Total order minimum not allowed', 204);
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

            // Encrip
            $params = ['orderID' => $order->id, 'transactionID' => $transaction->id];
            $eUrl = xpay_EncriptUrl($params);

            $redirectRoute = route('icommercexpay', [$eUrl]);

            // Response
            $response = ['data' => [
                'redirectRoute' => $redirectRoute,
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
     * XPAY API - Get Token Login
     *
     * @param Requests
     */
    public function getTokenLogin(Request $request): token
    {
        //\Log::info('Module Icommercexpay: GetTokenLogin');
        try {
            $paymentMethod = $this->getPaymentMethodConfiguration();
            if ($paymentMethod->options->mode == 'sandbox') {
                $endPoint = self::URL_SANDBOX.$this->urls['getTokenLogin'];
            } else {
                $endPoint = self::URL_PRODUCTION.$this->urls['getTokenLogin'];
            }

            $params = [
                'email' => $paymentMethod->options->user,
                'password' => $paymentMethod->options->pass,
            ];

            // SEND DATA xPay AND GET URL
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', $endPoint, [
                'body' => json_encode($params),
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            //\Log::info('Module Icommercexpay: xPay Response Code: '.$response->getStatusCode());
        } catch (\Exception $e) {
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
            //\Log::info('Module Icommercexpay: xPay Response Code: '.$e->getMessage());
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * XPAY API - Get Available currencies
     *
     * @param Requests Order
     * @return array currencies
     */
    public function getCurrencies(Request $request): array
    {
        try {
            $paymentMethod = $this->getPaymentMethodConfiguration();

            if ($paymentMethod->options->mode == 'sandbox') {
                $endPoint = self::URL_SANDBOX.$this->urls['getCurrencies']."{$request->order->total}/COC/";
            } else {
                $endPoint = self::URL_PRODUCTION.$this->urls['getCurrencies']."{$request->order->total}/{$request->order->currency_code}/";
            }

            // SEND DATA xPay AND Currencies
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $endPoint, [
                'headers' => [
                    'Authorization' => 'Token '.$paymentMethod->options->token,
                ],
            ]);

            $response = $res->getBody()->getContents();
        } catch (\Exception $e) {
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
     * @param Requests srcCurrency
     * @param Requests exchangeId
     * @return Json Information
     */
    public function createPayment(Request $request): Json
    {
        try {
            $data = $request['attributes'] ?? []; //Get data

            $paymentMethod = $this->getPaymentMethodConfiguration();

            $infor = xpay_DecriptUrl($data['encrp']);

            $order = $this->order->find($infor[0]);
            \Log::info('Module Icommercexpay: createPayment - OrderID: '.$order->id);
            \Log::info('Module Icommercexpay: createPayment - TransactionID: '.$infor[1]);

            // Transaction XPAY
            $res = $this->createTransaction($paymentMethod, $data, $order);
            $data = json_decode($res->getBody()->getContents());

            if ($data->id) {
                \Log::info('Module Icommercexpay: createPayment - XpayTransactionId: '.$data->id);

                $transactionUp = $this->validateResponseApi(
                    $this->transactionController->update($infor[1], new Request([
                        'external_code' => $data->id,
                    ]))
                );

                $qrImg = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='.urlencode($data->qr).'&choe=UTF-8';

                $response = $data;
                $response->qrImg = $qrImg;
            } else {
                throw new \Exception($data->error, 204);
            }
        } catch(\Exception $e) {
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
            \Log::error('Module Icommercexpay: Create Payment - Message: '.$e->getMessage());
            \Log::error('Module Icommercexpay: Create Payment - Code: '.$e->getCode());
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * XPAY API - Create Transaction
     *
     * @param Requests paymentMethod
     * @param Requests data
     * @param Requests order
     * @return Json Information
     */
    public function createTransaction($paymentMethod, $data, $order): Json
    {
        if ($paymentMethod->options->mode == 'sandbox') {
            $endPoint = self::URL_SANDBOX.$this->urls['createPayment'];
            $tgtCurrency = 'COC';
        } else {
            $endPoint = self::URL_PRODUCTION.$this->urls['createPayment'];
            $tgtCurrency = $order->currency_code;
        }

        $params = [
            'src_currency' => $data['srcCurrency'],
            'amount' => $order->total,
            'exchange_id' => $data['exchangeId'],
            'tgt_currency' => $tgtCurrency,
            'callback' => route('icommercexpay.api.xpay.response'),
        ];

        //Type raw
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $endPoint, [
            'body' => json_encode($params),
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Token '.$paymentMethod->options->token,
            ],
        ]);

        return $response;
    }

    /**
     * Response Callback
     *
     * @param Requests
     * @return Json Information
     */
    public function response(Request $request): Json
    {
        try {
            \Log::info('Module Icommercexpay: Response - Request ID: '.$request->id);
            \Log::info('Module Icommercexpay: Response - xPay Status: '.$request->status);

            $transaction = TransEnti::where('external_code', $request->id)->latest()->first();

            // Update Order
            $orderUP = $this->updateInformation($request, $transaction);

            $resp['xpayTranId'] = $request->id;
            $resp['xpayTranStatus'] = $request->status;
            $resp['orderId'] = $transaction->order_id;

            event(new ResponseWasReceived($resp));
        } catch(\Exception $e) {
            //Log Error
            \Log::error('Module Icommercexpay: Response - Message: '.$e->getMessage());
            \Log::error('Module Icommercexpay: Response - Code: '.$e->getCode());
        }

        return response('Recibido', 200);
    }

    /**
     * Get Payment Method Configuration
     */
    public function getPaymentMethodConfiguration(): collection
    {
        $paymentName = config('asgard.icommercexpay.config.paymentName');
        $attribute = ['name' => $paymentName];
        $paymentMethod = $this->paymentMethod->findByAttributes($attribute);

        return $paymentMethod;
    }

    /**
     * Update Information
     */
    public function updateInformation($request, $transaction): orderUpdated
    {
        $orderStatus = $request->status;
        $xpayId = $request->id;

        if ($orderStatus == 'sending') {
            //waiting for payment
            $newstatusOrder = 1; //Processing
        } elseif ($orderStatus == 'refunded') {
            //amount exceeded or total amount received was refunded
            $newstatusOrder = 8; //refunded
        } elseif ($orderStatus == 'approved') {
            //payment received
            $newstatusOrder = 13; //Processed
        } elseif ($orderStatus == 'cancelled') {
            //time expired,;
            $newstatusOrder = 14; //expired
        } elseif ($orderStatus == 'rejected') {
            //payment received, but out of valid time.
            $newstatusOrder = 5; //denied
        } else {
            $newstatusOrder = 7; // Status Order Failed
        }

        \Log::info('Module Icommercexpay: New Status Order: '.$newstatusOrder);

        // Update Transaction
        $transaction = $this->validateResponseApi(
            $this->transactionController->update($transaction->id, new Request([
                'status' => $newstatusOrder,
            ]))
        );

        // Update Order
        $orderUP = $this->validateResponseApi(
            $this->orderController->update($transaction->order_id, new Request(
                ['attributes' => [
                    'order_id' => $transaction->order_id,
                    'status_id' => $newstatusOrder,
                ],
                ]))
        );

        // Create History
        $comment = 'Xpay: '.$orderStatus.' - Transaction: '.$xpayId;
        $this->orderHistory->create(new Request([
            'attributes' => [
                'order_id' => $transaction->order_id,
                'status' => $newstatusOrder,
                'notify' => 1,
                'comment' => $comment,
            ],
        ]
        ));

        return $orderUP;
    }
}
