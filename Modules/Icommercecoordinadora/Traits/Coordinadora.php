<?php

namespace Modules\Icommercecoordinadora\Traits;

trait Coordinadora
{
    /**
     * GET API URL
     *
     * @param  int  $type (cotizacion)
     */
    private function getApiUrl($type)
    {
        $mode = 'sandbox';
        if ($this->methodConfiguration->options->mode == 'production') {
            $mode = 'production';
        }

        if ($type == 1) {
            $url = config('asgard.icommercecoordinadora.config.apiUrl.cotizacion.'.$mode);
        } else {
            $url = config('asgard.icommercecoordinadora.config.apiUrl.otro.'.$mode);
        }

        return $url;
    }

    /**
     * Init Client
     *
     * @param  int  $type (cotizacion)
     * @return client
     */
    public function initClientSoap($type = 1)
    {
        // Params
        $opts = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];

        $params = [
            'encoding' => 'UTF-8',
            'soap_version' => SOAP_1_2,
            'trace' => true,
            'exceptions' => true,
            'connection_timeout' => 180,
            'stream_context' => stream_context_create($opts),
        ];

        $url = $this->getApiUrl($type);

        // Create Client
        try {
            $client = new \SoapClient($url, $params);

            return $client;
        } catch (\Exception $e) {
            \Log::error('Module IcommerceCoordinadora: Init Client - Message: '.$e->getMessage());
            \Log::error('Module IcommerceCoordinadora: Init Client - Code: '.$e->getCode());

            //throw new  \Exception($e->getMessage());
        }
    }

    /**
     * @param TESTING
     */
    public function searchCity($data)
    {
        $city = null;
        foreach ($this->cities as $key => $city) {
            // OJOOOOO ESTO CAMBIAR
            if ($city->nombre_departamento == 'Antioquia') {
                return $city;
            }
        }

        return $city;
    }
}
