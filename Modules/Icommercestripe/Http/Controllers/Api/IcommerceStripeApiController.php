<?php

namespace Modules\Icommercestripe\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
//Request
use Modules\Icommerce\Http\Controllers\Api\OrderApiController;
// Base Api
use Modules\Icommerce\Http\Controllers\Api\TransactionApiController;
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Repositories\TransactionRepository;
// Repositories Icommerce
use Modules\Icommercestripe\Http\Requests\InitRequest;
use Modules\Icommercestripe\Repositories\IcommerceStripeRepository;
use Modules\Icommercestripe\Services\CreditService;
// Services
use Modules\Icommercestripe\Services\StripeService;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class IcommerceStripeApiController extends BaseApiController
{
    private $icommercestripe;

    private $order;

    private $orderController;

    private $transaction;

    private $transactionController;

    private $stripeApi;

    private $stripeService;

    private $creditService;

    private $paymentMethod;

    public function __construct(
        IcommerceStripeRepository $icommercestripe,
        OrderRepository $order,
        OrderApiController $orderController,
        TransactionRepository $transaction,
        TransactionApiController $transactionController,
        StripeApiController $stripeApi,
        StripeService $stripeService,
        CreditService $creditService
    ) {
        $this->icommercestripe = $icommercestripe;

        $this->order = $order;
        $this->orderController = $orderController;
        $this->transaction = $transaction;
        $this->transactionController = $transactionController;

        $this->stripeApi = $stripeApi;
        $this->stripeService = $stripeService;
        $this->creditService = $creditService;

        // Payment Method Configuration
        $this->paymentMethod = stripeGetConfiguration();
    }

    /**
     * Init Calculations (Validations to checkout)
     *
     * @param Request request
     * @return mixed
     */
    public function calculations(Request $request)
    {
        try {
            $paymentMethod = stripeGetConfiguration();
            $response = $this->icommercestripe->calculate($request->all(), $paymentMethod->options);
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
     * Init data to checkout
     *
     * @param Request - orderId
     */
    public function init(Request $request)
    {
        \Log::info('Icommercestripe: INIT: '.time());

        try {
            $data = $request->all();

            $this->validateRequestApi(new InitRequest($data));

            $orderID = $request->orderId;
            //\Log::info('Module Icommercestripe: Init-ID:'.$orderID);

            // Payment Method Configuration
            $paymentMethod = stripeGetConfiguration();

            // Order
            $order = $this->order->find($orderID);
            $statusOrder = 1; // Processing

            // Validate minimum amount order
            if (isset($paymentMethod->options->minimunAmount) && $order->total < $paymentMethod->options->minimunAmount) {
                throw new \Exception(trans('icommercestripe::icommercestripes.messages.minimum').' :'.$paymentMethod->options->minimunAmount, 204);
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

            $responseStripeApi = $this->stripeApi->generateLink($paymentMethod, $order, $transaction);

            // Check success
            if (isset($responseStripeApi->url)) {
                $redirectRoute = $responseStripeApi->url;
            } else {
                throw new \Exception('Icommercestripe - INIT - Generate Link URL', 500);
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
     * @param Request request
     */
    public function response(Request $request)
    {
        // Default Response
        $response = ['status' => 'error'];

        // Validation event
        $event = null;
        try {
            $event = \Stripe\Webhook::constructEvent(
                $request->getContent(), $request->header('stripe-signature'), $this->paymentMethod->options->signSecret
            );
            $response = ['status' => 'success'];
        } catch(\UnexpectedValueException $e) {
            $status = 400;
            \Log::error('Icommercestripe: Response - Error: Invalid Payload');
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            $status = 400;
            \Log::error('Icommercestripe: Response - Error: Signature');
        }

        // Check Event Type
        if (isset($event->type)) {
            \Log::info('Icommercestripe: Response|EventType: '.$event->type);

            if ($event->data->object->object == 'checkout.session') {
                $this->orderProcess($event);
            }
            if ($event->data->object->object == 'charge') {
                $this->chargesProcess($event);
            }
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Create Account with Link to Onboarding proccess
     *
     * @param Request request
     */
    public function connectCreateAccountLinkOnboarding(Request $request)
    {
        \Log::info('Icommercestripe: Connect|CreateAccountLinkOnboarding');

        $response['status'] = 'success';

        try {
            $data = $request['attributes'] ?? []; //Get data

            // Check if user has a payoutStripeConfig
            $userConfig = $this->stripeService->findPayoutConfigUser();

            if (is_null($userConfig)) {
                // Create Account
                $account = $this->stripeApi->createAccount($this->paymentMethod->options->secretKey, $data);

                $accountId = $account->id;

                $response['title'] = trans('icommercestripe::icommercestripes.messages.accountCreated');

                // Save infor in User Profile Field
                $fieldCreated = $this->stripeService->syncDataUserField(['accountId' => $accountId]);
            } else {
                $response['title'] = trans('icommercestripe::icommercestripes.messages.accountAlreadyHave');

                // Get account Id from Field
                $accountId = $userConfig->value->accountId;
            }

            // Create Account Link
            $accountLink = $this->stripeApi->createLinkAccount($this->paymentMethod->options->secretKey, $accountId);

            //Event to Activity
            if (is_module_enabled('Igamification')) {
                event(new \Modules\Igamification\Events\ActivityWasCompleted([
                    'extraData' => [
                        'systemNameActivity' => 'setup-wallet',
                    ],
                ])
                );
            }

            //Response
            $response['description'] = trans('icommercestripe::icommercestripes.messages.verifyAccount').$accountLink;

            //Data
            $response['data'] = [
                'accountRegisterLink' => $accountLink,
            ];
        } catch (\Exception $e) {
            \Log::error('Icommercestripe: Connect|CreateAccountLinkOnboarding|Message: '.$e->getMessage());

            $status = 500;
            $response = [
                'status' => 'error',
                'title' => 'Ha ocurrido un error',
                'description' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Get Account Data and Create urlPanel (Login Link) if it is not saved in profile field
     *
     * @param Request request
     */
    public function connectGetAccount(Request $request)
    {
        \Log::info('Icommercestripe: Connect|GetAccount');

        try {
            $data = $request['attributes'] ?? []; //Get data

            // Get Account ID - Just for testing API
            if (isset($data['accountId'])) {
                $accountId = $data['accountId'];
            } else {
                // Check if user has a payoutStripeConfig from logged user
                $userConfig = $this->stripeService->findPayoutConfigUser();

                if (! is_null($userConfig)) {
                    // Get account Id from Field
                    $accountId = $userConfig->value->accountId;
                } else {
                    throw new \Exception('User PayoutConfigStripe Data - No Exist', 204);
                }
            }

            // Response Infor Account
            $accountInfor = $this->stripeApi->retrieveAccount($this->paymentMethod->options->secretKey, $accountId);

            // Check if exist urlPanel
            if (isset($userConfig) && isset($userConfig->value->urlPanel)) {
                \Log::info('Icommercestripe: Connect|GetAccount|The user has an urlPanel');

                $responseTent['urlPanel'] = $userConfig->value->urlPanel;
            } else {
                // Validate if can create a login link
                if (stripeValidateAccountRequirements($accountInfor)) {
                    // Create Login Link
                    $responseLoginLink = $this->stripeApi->createLoginLink($this->paymentMethod->options->secretKey, $accountId);

                    // Save infor in User Profile Field
                    $fieldCreated = $this->stripeService->syncDataUserField(['urlPanel' => $responseLoginLink->url]);

                    // Add to response
                    $responseTent['urlPanel'] = $responseLoginLink->url;

                    /*
                    if (is_module_enabled("Igamification")) event(new \Modules\ Igamification\Events\ActivityWasCompleted([
                                'extraData' => [
                                'systemNameActivity' => 'setup-wallet'
                            ]
                        ])
                    );
                    */
                } else {
                    $responseTent['urlPanelMsj'] = trans('icommercestripe::icommercestripes.validation.accountIncompletePanelUrl');
                }
            }

            // Response
            $responseTent['email'] = $accountInfor->email;
            $responseTent['detailsSubmitted'] = $accountInfor->details_submitted;
            $responseTent['chargesEnabled'] = $accountInfor->charges_enabled; //Pagos
            $responseTent['payoutsEnabled'] = $accountInfor->payouts_enabled; //Transf

            $response['data'] = $responseTent;
        } catch (\Exception $e) {
            \Log::error('Icommercestripe: Connect|GetAccount|Message: '.$e->getMessage());
            $status = $e->getCode();
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Create login link
     *
     * @param Request - attributes['accountId']
     */
    public function connectCreateLoginLink(Request $request)
    {
        \Log::info('Icommercestripe: Connect|CreateLoginLink');

        try {
            $data = $request['attributes'] ?? []; //Get data

            // Payment Method Configuration
            $paymentMethod = stripeGetConfiguration();

            $result = $this->stripeApi->createLoginLink($paymentMethod, $data['accountId']);

            $response = $result;
        } catch (\Exception $e) {
            \Log::error('Icommercestripe: Connect|CreateLoginLink|Message: '.$e->getMessage());
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Just Testing - not used yet in a process
     *
     * @param Requests request
     */
    public function connectAccountResponse(Request $request)
    {
        \Log::info('Icommercestripe: Response - Account - '.time());

        // Default Response
        $response = ['status' => 'error'];

        // Handle the event
        /*
        switch ($event->type) {
          case 'account.updated':
            $account = $event->data->object;
          case 'account.application.authorized':
            $application = $event->data->object;
          case 'account.application.deauthorized':
            $application = $event->data->object;
          case 'account.external_account.created':
            $externalAccount = $event->data->object;
          case 'account.external_account.deleted':
            $externalAccount = $event->data->object;
          case 'account.external_account.updated':
            $externalAccount = $event->data->object;
          // ... handle other event types
          default:
            echo 'Received unknown event type ' . $event->type;
        }
        */

        return response()->json($response, $status ?? 200);
    }

    /**
     * Just Testing - not used yet in a process
     *
     * @param Request - attributes['countryCode']
     * @return Countries Stripe
     */
    public function connectGetCountry(Request $request)
    {
        \Log::info('Icommercestripe: Connect|GetCountry');

        try {
            $data = $request['attributes'] ?? []; //Get data

            // Payment Method Configuration
            $paymentMethod = stripeGetConfiguration();

            $responseStripe = $this->stripeApi->retrieveCountry($paymentMethod->options->secretKey, $data['countryCode'] ?? false);

            if (! isset($data['countryCode']) && count($responseStripe['data']) > 0) {
                $response['data'] = [
                    'countries' => $responseStripe['data'],
                    'count' => count($responseStripe['data']),
                ];
            } else {
                $response = $responseStripe;
            }
        } catch (\Exception $e) {
            \Log::error('Icommercestripe: Connect|GetCountry|Message '.$e->getMessage());
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Just Testing - not used yet in a process
     * Get information about a Transfer with the "destination_payment" and "balance_transaction"
     *
     * @param Request - attributes['transferId']
     * @return Transfer Stripe
     */
    public function connectGetTransfer(Request $request)
    {
        \Log::info('Icommercestripe: Connect|GetTransfer');

        try {
            $data = $request['attributes'] ?? []; //Get data

            // Payment Method Configuration
            $paymentMethod = stripeGetConfiguration();

            $response = $this->stripeApi->retrieveTransfer($paymentMethod->options->secretKey, $data['transferId']);
        } catch (\Exception $e) {
            \Log::error('Icommercestripe: Connect|GetTransfer|Message '.$e->getMessage());
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Just Testing - not used yet in a process
     * Get information about a Balance Transaction
     *
     * @param Request - attributes['balanceIdTransaction']
     * @return Balance Transaction Stripe
     */
    public function connectGetBalanceTransaction(Request $request)
    {
        \Log::info('Icommercestripe: Connect|GetBalanceTransaction');

        try {
            $data = $request['attributes'] ?? []; //Get data

            // Payment Method Configuration
            $paymentMethod = stripeGetConfiguration();

            $response = $this->stripeApi->retrieveBalanceTransaction($paymentMethod->options->secretKey, $data['balanceIdTransaction']);
        } catch (\Exception $e) {
            \Log::error('Icommercestripe: Connect|GetBalanceTransaction|Message: '.$e->getMessage());
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Update Order and Transaction
     *
     * @param $event - (stripe information webhook)
     */
    public function orderProcess($event)
    {
        \Log::info('Icommercestripe: Response|OrderProcess|INIT');

        // Get all infor about status
        $details = $this->stripeService->getStatusDetail($event);

        if (isset($details['orderId'])) {
            //\Log::info('Icommercestripe: Response|OrderProcess|Updating OrderId: '.$details['orderId']);

            // Update Transaction
            $transaction = $this->validateResponseApi(
                $this->transactionController->update($details['transactionId'], new Request([
                    'status' => $details['newStatus'],
                ]))
            );

            // Update Order Process
            $orderUP = $this->validateResponseApi(
                $this->orderController->update($details['orderId'], new Request(
                    ['attributes' => [
                        'status_id' => $details['newStatus'],
                        'comment' => 'Orden actualizada por: Stripe',
                    ],
                    ]))
            );
        }
        \Log::info('Icommercestripe: Response|OrderProcess|END');
    }

    /**
     * Create transfer to each product
     *
     * @param $event - (stripe information webhook)
     */
    public function chargesProcess($event)
    {
        // Get Charge Infor
        $charge = $event->data->object;
        \Log::info('Icommercestripe: ChargeProcess|ChargeId: '.$charge->id);

        //Get order id from transfer group
        $infor = stripeGetInforTransferGroup($charge->transfer_group);
        $order = $this->order->find($infor[1]);

        // Testing data
        //$order = $this->order->find(49);

        //Set Stripe Transfer
        \Stripe\Stripe::setApiKey($this->paymentMethod->options->secretKey);

        // Get Base description to each Transfer
        $description = stripeGetOrderDescription($order);

        // Currency Code from Config PaymentMethod
        $currencyAccount = $this->paymentMethod->options->currency;

        // Currency Value from Icommerce
        $currencyConvertionValue = stripeGetCurrencyValue($currencyAccount);

        // Each Transfer to Order Child
        foreach ($order->children as $key => $orderChild) {
            if (! empty($orderChild->organization_id)) {
                \Log::info('Icommercestripe: ChargeProcess|OrderChild ID: '.$orderChild->id);

                //Get account Id to destination transfer
                $accountInfor = $this->stripeService->getAccountIdByOrganizationId($orderChild->organization_id, true);

                if (! is_null($accountInfor)) {
                    // Get the amount in the currency of the Stripe Main Account
                    $totalOrder = stripeGetAmountConvertion($orderChild->currency_code, $currencyAccount, $orderChild->total, $currencyConvertionValue);

                    // Get Comision
                    $comision = $this->stripeService->getComisionToDestination($accountInfor['user'], $totalOrder);

                    //Amount to Transfer
                    $amountTransfer = $totalOrder - $comision;

                    //All API requests expect amounts to be provided in a currency’s smallest unit
                    $amountInCents = $amountTransfer * 100;

                    try {
                        $transfer = \Stripe\Transfer::create([
                            'amount' => $amountInCents,
                            'currency' => $currencyAccount,
                            'source_transaction' => $charge->id,
                            'destination' => $accountInfor['accountId'],
                            'transfer_group' => $charge->transfer_group,
                            'description' => $description.'- Transfer - Oc #'.$orderChild->id,
                            'metadata' => [
                                'TO' => $totalOrder,
                                'CM' => $comision,
                                'TT' => $amountTransfer,
                            ],
                            //'expand' => ['destination_payment.balance_transaction']
                        ]);

                        //\Log::info('Balance Transaction: '.json_encode($transfer->destination_payment->balance_transaction));

                        \Log::info('Icommercestripe: ChargeProcess|Created Transfer to: '.$accountInfor['accountId']);

                        // Create credit Order Child and Order Parent
                        $this->creditService->create($orderChild, $accountInfor, $transfer, $order);
                    } catch (Exception $e) {
                        \Log::error('Icommercestripe: ChargeProcess|Transfer|Message: '.$e->getMessage());
                    }
                } else {
                    \Log::info('Icommercestripe: ChargeProcess: El destino no tiene cuenta connect y no se puede realizar la transferencia');
                }
            } else {
                \Log::info('Icommercestripe: ChargeProcess|No Organization Id to Order Child ID: '.$orderChild->id);
            }
        }//Foreach

        \Log::info('Icommercestripe: ChargeProcess|END');
    }
}
