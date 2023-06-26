<?php

namespace Modules\Icommercebraintree\Http\Controllers;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// Base
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Repositories\TransactionRepository;
use Modules\Icommercebraintree\Http\Controllers\Api\BraintreeApiController;

class PublicController extends BasePublicController
{
    private $paymentMethod;

    private $order;

    private $transaction;

    private $braintreeApi;

    public function __construct(
        PaymentMethodRepository $paymentMethod,
        OrderRepository $order,
        TransactionRepository $transaction,
        BraintreeApiController $braintreeApi
    ) {
        $this->paymentMethod = $paymentMethod;
        $this->order = $order;
        $this->transaction = $transaction;
        $this->braintreeApi = $braintreeApi;
    }

    /**
     * Index data
     *
     * @param Requests request
     * @return route
     */
    public function index($eURL): route
    {
        try {
            // Decr
            $infor = braintree_decriptUrl($eURL);
            $orderID = $infor[0];
            $transactionID = $infor[1];

            //\Log::info('Module Icommerceepayco: Index-ID:'.$orderID);

            // Validate get data
            $order = $this->order->find($orderID);
            $transaction = $this->transaction->find($transactionID);

            // Get Payment Method Configuration
            $paymentMethod = braintree_getPaymentMethodConfiguration();

            // Get Token
            $tokenBraintree = $this->braintreeApi->generateClientToken();

            //View
            $tpl = 'icommercebraintree::frontend.index';

            return view($tpl, compact('tokenBraintree', 'order', 'eURL'));
        } catch (\Exception $e) {
            \Log::error('Module Icommercebraintree-Index: Message: '.$e->getMessage());
            \Log::error('Module Icommercebraintree-Index: Code: '.$e->getCode());

            //Message Error
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
                'code' => $e->getCode(),
            ];

            return redirect()->route('homepage');
        }
    }

    public function processPayment(Request $request, $eURL)
    {
        \Log::info('Procesaarrr');
    }
}
