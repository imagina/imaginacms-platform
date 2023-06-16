<?php

namespace Modules\Icommercewompi\Services;

use Modules\Icommercewompi\Entities\Wompi as WompiEntity;

class WompiService
{
    public function __construct()
    {
    }

    /**
     * Configuration to reedirect
     *
     * @return object Configuration
     */
    public function create($paymentMethod, $order, $transaction, $urls)
    {
        $wompi = new WompiEntity();

        $urlWompi = $paymentMethod->options->mode == 'sandbox' ? $urls['sandbox'] : $urls['production'];

        $wompi->setUrlgate($urlWompi);
        $wompi->setPublicKey($paymentMethod->options->publicKey);
        $wompi->setReferenceCode(icommercewompi_getOrderRefCommerce($order, $transaction));
        $wompi->setAmount(round($order->total)); //No admite decimales
        $wompi->setCurrency($order->currency_code);
        $wompi->setRedirectUrl(Route('icommercewompi.response', $order->id));

        return $wompi;
    }

    /**
     * Make the Signature
     *
     * @param Requests request
     * @param Payment Method
     * @return signature
     */
    public function makeSignature($request, $paymentMethod)
    {
        $transaction = $request->data['transaction'];
        $signatureProps = $request->signature['properties'];

        $concatProps = '';
        foreach ($signatureProps as $key => $prop) {
            $result = explode('.', $prop);
            $concatProps .= $transaction[$result[1]];
        }

        $concatProps .= $request->timestamp.$paymentMethod->options->eventSecretKey;

        $signature = hash('sha256', $concatProps);

        return $signature;
    }

    /**
     * Get Status to Order
     *
     * @param int cod
     * @return int
     */
    public function getStatusOrder($cod)
    {
        switch ($cod) {
            case 'APPROVED': // Aceptada
                $newStatus = 13; //processed
                break;

            case 'DECLINED': // Rechazada
                $newStatus = 5; //denied
                break;

            case 'VOIDED': // Transacción anulada (sólo aplica pra transacciones con tarjeta)
                $newStatus = 12; //voided
                break;

            case 'ERROR': // Fallida
                $newStatus = 7; //failed
                break;
        }

        \Log::info('Module Icommerceepayco: New Status: '.$newStatus);

        return $newStatus;
    }
}
