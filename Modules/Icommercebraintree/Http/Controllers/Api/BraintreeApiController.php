<?php

namespace Modules\Icommercebraintree\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class BraintreeApiController extends BaseApiController
{
    private $gateway;

    private $braintreeService;

    public function __construct()
    {
        $this->gateway = $this->getGateway();
        $this->braintreeService = app("Modules\Icommercebraintree\Services\BraintreeService");
    }

    /**
     * Braintree API - Get gateway
     *
     * @return gateway
     */
    public function getGateway(): gateway
    {
        // Payment Method Configuration
        $paymentMethod = braintree_getPaymentMethodConfiguration();

        $config = new \Braintree\Configuration([
            'environment' => $paymentMethod->options->mode,
            'merchantId' => $paymentMethod->options->merchantId,
            'publicKey' => $paymentMethod->options->publicKey,
            'privateKey' => $paymentMethod->options->privateKey,
        ]);

        $gateway = new \Braintree\Gateway($config);

        return $gateway;
    }

    /**
     * Braintree API - Generate Client Token
     *
     * @return token
     */
    public function generateClientToken(): token
    {
        $clientToken = $this->gateway->clientToken()->generate();

        return $clientToken;
    }

    /**
     * Braintree API - Create Transaction
     *
     * @return result
     */
    //https://developer.paypal.com/braintree/docs/reference/request/transaction/submit-for-settlement
    public function createTransaction($order, $nonceFromTheClient): result
    {
        //Optional
        $customer = [
            'email' => $order->email,
            'firstName' => $order->first_name,
            'lastName' => $order->last_name,
        ];

        $result = $this->gateway->transaction()->sale([
            'orderId' => $order->id,
            'amount' => $order->total,
            'paymentMethodNonce' => $nonceFromTheClient,
            'customer' => $customer,
            'options' => [
                'submitForSettlement' => true,
            ],
        ]);

        return $result;
    }

    /**
     * Braintree API - Get Transaction
     *
     * @return transaction
     */
    public function getTransaction($id): transaction
    {
        $transaction = $this->gateway->transaction()->find($id);

        return $transaction;
    }

    /**
     * Braintree API - Create Payment Method
     */
    public function createPaymentMethod($customerId, $nonceFromTheClient)
    {
        $result = $this->gateway->paymentMethod()->create([
            'customerId' => $customerId,
            'paymentMethodNonce' => $nonceFromTheClient,
        ]);

        return $result;
    }

    /**
     * Braintree API - Create Customer
     */
    public function createCustomer($order, $nonceFromTheClient)
    {
        $result = $this->gateway->customer()->create([
            'id' => $order->customer_id,
            'firstName' => $order->first_name,
            'lastName' => $order->last_name,
            'email' => $order->email,
            'paymentMethodNonce' => $nonceFromTheClient,
        ]);

        return $result;
    }

    /**
     * Braintree API - Find Customer
     */
    public function findCustomer($id)
    {
        try {
            $customer = $this->gateway->customer()->find($id);
        } catch(\Exception $e) {
            \Log::info('Module Icommercebraintree: Find Customer - Not Found');

            $customer = null;
        }

        return $customer;
    }

    /**
     * Braintree API - Create Suscription
     */
    public function createSuscription($order, $data)
    {
        $planId = $data['planId'];
        $nonceFromTheClient = $data['clientNonce'];
        $planPrice = null;

        if (isset($data['planPrice'])) {
            $planPrice = $data['planPrice'];
        }

        $customer = $this->findCustomer($order->customer_id);

        // Customer Exist
        if (isset($customer->id)) {
            // Add Payment Method
            $createdPaymentMethod = $this->createPaymentMethod($customer->id, $nonceFromTheClient);

            if ($createdPaymentMethod->success) {
                // Get NEW Payment Method Token
                $newPaymentMethodToken = $createdPaymentMethod->paymentMethod->token;

                // Get Data to Suscription
                $dataSubscription = $this->braintreeService->getDataToSuscription($newPaymentMethodToken, $planId, $planPrice);

                // Add Suscription
                $result = $this->gateway->subscription()->create($dataSubscription);
            } else {
                $errors = $this->braintreeService->getErrors($createdPaymentMethod->errors->deepAll());

                \Log::error('Icommercebraintree: Braintree API - Create suscription - createdPaymentMethod');

                throw new \Exception($errors['string'], 204);
            }
        } else {
            // New Customer
            $createdCustomer = $this->createCustomer($order, $nonceFromTheClient);

            if ($createdCustomer->success) {
                // Get Payment Method Token
                $paymentToken = $createdCustomer->customer->paymentMethods[0]->token;

                // Get Data to Suscription
                $dataSubscription = $this->braintreeService->getDataToSuscription($paymentToken, $planId, $planPrice);

                // Add Suscription
                $result = $this->gateway->subscription()->create($dataSubscription);
            } else {
                $errors = $this->braintreeService->getErrors($createdCustomer->errors->deepAll());

                \Log::error('Icommercebraintree: Braintree API - Create suscription - createdCustomer');

                throw new \Exception($errors['string'], 204);
            }
        }

        return $result;
    }
}
