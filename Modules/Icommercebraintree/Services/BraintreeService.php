<?php

namespace Modules\Icommercebraintree\Services;

class BraintreeService
{
    public function __construct()
    {
    }

    /**
     * Get Status to Order
     *
     * @param Braintree Transaction
     * @return int
     */
    public function getStatusOrder($cod)
    {
        \Log::info('Module Icommercebraintree: Status Braintree: '.$cod);

        switch ($cod) {
            // The processor authorized the transaction. Your customer may see a pending charge on his or her account. However, before the customer is actually charged and before you receive the funds, you must submit the transaction for settlement.
            case \Braintree\Transaction::AUTHORIZED:
                $newStatus = 13; // Procesado
                break;

                // AUTHORIZING
            case \Braintree\Transaction::AUTHORIZING:
                $newStatus = 13; // Procesado
                break;

                // The transaction has been settled.
            case \Braintree\Transaction::SETTLED:
                $newStatus = 13; // Procesado
                break;

                // The transaction is in the process of being settled. This is a transitory state. A transaction can't be voided once it reaches Settling status, but can be refunded.
            case \Braintree\Transaction::SETTLING:
                $newStatus = 13; // Procesado
                break;

                //SETTLEMENT_CONFIRMED
            case \Braintree\Transaction::SETTLEMENT_CONFIRMED:
                $newStatus = 13; // Procesado
                break;

                // The transaction has not yet fully settled. This status is rare, and it does not always indicate a problem with settlement. Only certain types of transactions can be affected.
            case \Braintree\Transaction::SETTLEMENT_PENDING:
                $newStatus = 13; // Procesado
                break;

                // The transaction has been submitted for settlement and will be included in the next settlement batch. Settlement happens nightly – the exact time depends on the processor.
            case \Braintree\Transaction::SUBMITTED_FOR_SETTLEMENT:
                $newStatus = 13; // Procesado
                break;

            default: // Fallida
                $newStatus = 7; //failed
                break;
        }

        \Log::info('Module Icommercebraintree: New Status Order: '.$newStatus);

        return $newStatus;
    }

    /**
     * Get Status to Order
     *
     * @param Braintree Errors Transaction
     * @return array
     */
    public function getErrors($errors)
    {
        $errorsGral = [];
        $errorsString = '';

        foreach ($errors as $error) {
            $errorsString .= 'Error: '.$error->code.': '.$error->message."\n";
            $errorsGral['msj'] = $error->message;
            $errorsGral['code'] = $error->code;
        }

        $errorsGral['string'] = $errorsString;

        return $errorsGral;
    }

    /**
     * Get Data
     *
     * @return array
     */
    public function getDataToSuscription($token, $planId, $planPrice)
    {
        $dataSubscription = [
            'paymentMethodToken' => $token,
            'planId' => $planId,
        ];

        // Check to override plan price
        if (! is_null($planPrice)) {
            $dataSubscription['price'] = $planPrice;
        }

        return $dataSubscription;
    }
}
