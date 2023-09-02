<?php

namespace Modules\Icommerceepayco\Services;

class EpaycoService
{
    public function __construct()
    {
    }

    /**
     * Make configuration to view in JS
     *
     * @return object Configuration
     */
    public function makeConfiguration($paymentMethod, $order, $transaction, $urls)
    {
        $urlEpayco = $paymentMethod->options->test ? $urls['sandbox'] : $urls['production'];

        $configuration['url'] = $urlEpayco;
        $configuration['publicKey'] = $paymentMethod->options->publicKey;
        $configuration['amount'] = $order->total;

        $infor = "Orden #{$order->id} - {$order->first_name} {$order->last_name}";

        $configuration['name'] = $infor;
        $configuration['description'] = $infor;
        $configuration['currency'] = $order->currency_code;
        $configuration['country'] = $order->payment_country;
        $configuration['test'] = $paymentMethod->options->test;

        $configuration['external'] = false;

        // Route Frontend after Payment
        $configuration['responseUrl'] = route('icommerceepayco.response', $order->id);

        // Route API confirmation after Payment
        $configuration['confirmationUrl'] = route('icommerceepayco.api.epayco.confirmation');

        $configuration['invoice'] = icommerceepayco_getOrderRefCommerce($order, $transaction);

        $configuration['autoClick'] = $paymentMethod->options->autoClick;

        $configuration['extra1'] = $order->id;

        return json_decode(json_encode($configuration));
    }

    /**
     * Show Values Vars in Log File
     *
     * @param Requests request
     */
    public function showVarsLog($request)
    {
        \Log::info('Module Icommerceepayco: ref_payco: '.$request->x_ref_payco);
        \Log::info('Module Icommerceepayco: order_id: '.$request->x_extra1);
        //\Log::info('Module Icommerceepayco: transaction_id: '.$request->x_transaction_id);
        //\Log::info('Module Icommerceepayco: cod_response: '.$request->x_cod_response);
        //\Log::info('Module Icommerceepayco: response: '.$request->x_response);
        \Log::info('Module Icommerceepayco: cod_transaction_state: '.$request->x_cod_transaction_state);
        \Log::info('Module Icommerceepayco: transaction_state: '.$request->x_transaction_state);
    }

    /**
     * Make the Signature
     *
     * @param Requests request
     * @param Payment Method
     */
    public function makeSignature($request, $paymentMethod)
    {
        $p_cust_id_cliente = $paymentMethod->options->clientId;
        $p_key = $paymentMethod->options->pKey;

        $x_ref_payco = $request->x_ref_payco;
        $x_transaction_id = $request->x_transaction_id;
        $x_amount = $request->x_amount;
        $x_currency_code = $request->x_currency_code;

        $signature = hash('sha256', $p_cust_id_cliente.'^'.$p_key.'^'.$x_ref_payco.'^'.$x_transaction_id.'^'.$x_amount.'^'.$x_currency_code);

        return $signature;
    }

    /**
     * Get Status to Order
     *
     * @param int cod
     */
    public function getStatusOrder($cod)
    {
        switch ((int) $cod) {
            case 1: // Aceptada
                $newStatus = 13; //processed
                break;

            case 2: // Rechazada
                $newStatus = 5; //denied
                break;

            case 3: // Pendiente
                $newStatus = 1; //pending
                break;

            case 4: // Fallida
                $newStatus = 7; //failed
                break;

            case 6: // Reversada
                $newStatus = 8; //refunded
                break;

            case 7: // Retenida
                $newStatus = 1; // Pendiente
                break;

            case 8: // Iniciada
                $newStatus = 1; // Pendiente
                break;

            case 9: // Expirada
                $newStatus = 14; // Expired
                break;

            case 10: // Abandonada
                $newStatus = 3; // Canceled
                break;

            case 11: // Cancelada
                $newStatus = 3; // Canceled
                break;

            case 12: // Antifraude
                $newStatus = 7; // failed
                break;

            case 99: // Error Sign
                $newStatus = 7; // failed
                break;
        }

        \Log::info('Module Icommerceepayco: New Status: '.$newStatus);

        return $newStatus;
    }
}
