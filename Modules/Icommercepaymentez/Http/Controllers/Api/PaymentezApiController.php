<?php

namespace Modules\Icommercepaymentez\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Response;
// Base Api
use Modules\Icommercepaymentez\Services\PaymentezService;
// Services
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class PaymentezApiController extends BaseApiController
{
    private $paymentezService;

    public function __construct(PaymentezService $paymentezService)
    {
        $this->paymentezService = $paymentezService;
    }

    /**
     *  API - Generate Auth Token
     */
    public function generateAuthToken($paymentMethod)
    {
        \Log::info('Icommercepaymentez: Generate Auth Token');

        $server_application_code = $paymentMethod->options->serverAppCode;
        $server_app_key = $paymentMethod->options->serverAppKey;

        $date = new \DateTime();
        $unix_timestamp = $date->getTimestamp();

        $uniq_token_string = $server_app_key.$unix_timestamp;
        $uniq_token_hash = hash('sha256', $uniq_token_string);

        $authToken = base64_encode($server_application_code.';'.$unix_timestamp.';'.$uniq_token_hash);

        return $authToken;
    }

    /**
     *  API - Generate Link
     */
    public function generateLink($paymentMethod, $order)
    {
        \Log::info('Icommercepaymentez: Generate Link');

        try {
            $token = $this->generateAuthToken($paymentMethod);

            $conf = $this->paymentezService->makeConfigurationToGenerateLink($paymentMethod, $order);

            $client = new \GuzzleHttp\Client();

            $responsePaymentez = $client->request('POST', $conf['endPoint'], [
                'body' => json_encode($conf['params']),
                'headers' => [
                    'auth-token' => $token,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $result = json_decode($responsePaymentez->getBody()->getContents());

            // Check success
            if ($result->success) {
                return $result->data->payment->payment_url;
            } else {
                throw new \Exception('Error - Payment URL', 500);
            }
        } catch (\Exception $e) {
            \Log::error('Icommercepaymentez: Generate Link - Message: '.$e->getMessage());

            //Message Error
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }
}
