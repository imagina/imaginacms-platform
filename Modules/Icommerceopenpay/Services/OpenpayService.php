<?php

namespace Modules\Icommerceopenpay\Services;

class OpenpayService
{
    public function __construct()
    {
    }

    /**
     * Make configuration to view in JS
     *
     * @return object Configuration
     */
    public function makeConfiguration($paymentMethod, $order, $transaction)
    {
        $conf['merchantId'] = $paymentMethod->options->merchantId ?? null;
        $conf['publicKey'] = $paymentMethod->options->publicKey ?? null;

        $conf['sandboxMode'] = true;
        if ($paymentMethod->options->mode != 'sandbox') {
            $conf['sandboxMode'] = false;
        }

        $conf['reedirectAfterPayment'] = $order->url;

        $conf['order'] = $order;
        $conf['transaction'] = $transaction;

        $conf['paymentModes'] = config('asgard.icommerceopenpay.config.paymentModes');

        return json_decode(json_encode($conf));
    }

    /**
     * Save verification code in method configuration
     *
     * @param $request (Openpay)
     * @param $paymentMethod (configuration)
     */
    public function saveVerificationCode($request, $paymentMethod)
    {
        if ($request->verification_code) {
            \Log::info('IcommerceOpenpay: Services|OpenpayService|saveVerificationCode|Code: '.$request->verification_code);

            // Add verfication code
            $options = $paymentMethod->options;
            $options->webhookVerificationCode = $request->verification_code;

            //Save options
            $paymentMethod->options = $options;
            $paymentMethod->save();
        }
    }

    /**
     * Get Status to Order
     */
    public function getStatusOrder($type)
    {
        switch ($type) {
            case 'charge.succeeded'://Indica que el cargo se ha completado (tarjeta, banco o tienda)
                $newStatus = 13; //processed
                break;

            case 'charge.refunded': //Un cargo a tarjeta fue reembolzado.
                $newStatus = 8; //refunded
                break;

            case 'charge.failed': //Un cargo a tarjeta fue fallido,expirado
                $newStatus = 7; //failed
                break;

            case 'charge.cancelled': // Un cargo cancelado
                $newStatus = 3; //canceled
                break;

            case 'charge.rescored.to.decline': // Informa cuando a un cargo le es recalculado su score y es declinado.
                $newStatus = 5; //denied
                break;

            case 'chargeback.accepted': //El contracargo se ha perdido. Se ha creado una transacción tipo contracargo que descontará los fondos de tu cuenta.
                $newStatus = 10; //chargeback
                break;

            case 'transaction.expired': //OJO: Este no aparece en la documentacion, fue porque llegó en el log y se agrego
                $newStatus = 14; //expired
                break;

            default:
                $newStatus = 1; //pending
        }

        \Log::info('IcommerceOpenpay: Services|OpenpayService|getStatusOrder|NewStatus: '.$newStatus);

        return $newStatus;
    }
}
