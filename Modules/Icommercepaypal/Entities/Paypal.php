<?php

namespace Modules\Icommercepaypal\Entities;

use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class Paypal
{
    private $apiContext;

    private $config;

    private $urlReturn;

    private $urlCancel;

    /**
     * Set Payer
     *
     * @param    $config (Payment Configuration)
     */
    public function __construct($config)
    {
        $this->config = $config;

        $this->urlReturn = 'icommercepaypal.response';
        $this->urlCancel = 'icommercepaypal.response';

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $this->config->options->clientId,
                $this->config->options->clientSecret
            )
        );

        $conf = config('asgard.icommercepaypal.config.configurations');
        $conf['mode'] = $this->config->options->mode;

        $this->apiContext->setConfig($conf);
    }

    /**
     * Set Payer
     *
     * @return $payer
     */
    public function setPayer()
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        return $payer;
    }

    /**
     * Set Amount
     *
     * @return $amount
     */
    public function setAmount($order)
    {
        $amount = new Amount();

        $total = icommercepaypal_getOrderTotalConvertion($order, $this->config);
        $amount->setTotal($total);

        $amount->setCurrency($this->config->options->currency);

        return $amount;
    }

    /**
     * Set Transaction
     *
     * @param    $amount (Paypa Obj)
     * @return $transaction
     */
    public function setTransaction($amount, $order, $ordTransaction)
    {
        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $description = 'OrderId: '.$order->id.'- Email: '.$order->email;
        $transaction->setDescription($description);

        $transaction->setInvoiceNumber(icommercepaypal_getOrderRefCommerce($order, $ordTransaction));

        return $transaction;
    }

    /**
     * Set Redirect Urls
     *
     * @return $redirectUrls
     */
    public function setRedirectUrls($order, $ordTransaction)
    {
        $callbackUrl = route($this->urlReturn, [$order->id, $ordTransaction->id]);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($callbackUrl)
            ->setCancelUrl($callbackUrl);

        return $redirectUrls;
    }

    /**
     * Generate the Payment
     *
     * @return $payment
     */
    public function generatePayment($order, $ordTransaction)
    {
        $payer = $this->setPayer();
        $amount = $this->setAmount($order);
        $transaction = $this->setTransaction($amount, $order, $ordTransaction);
        $redirectUrls = $this->setRedirectUrls($order, $ordTransaction);

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

        $payment->create($this->apiContext);

        return $payment;
    }

    /**
     * Get the Payment Information
     *
     * @return $result
     */
    public function getPaymentInfor($paymentId, $payerId)
    {
        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        $result = $payment->execute($execution, $this->apiContext);

        return $result;
    }
}
