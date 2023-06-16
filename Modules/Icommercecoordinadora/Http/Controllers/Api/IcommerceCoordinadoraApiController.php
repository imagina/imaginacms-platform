<?php

namespace Modules\Icommercecoordinadora\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
// Repositories

use Modules\Iprofile\Repositories\AddressRepository;

class IcommerceCoordinadoraApiController extends BaseApiController
{
    private $coordinadoraApi;

    private $addressRepository;

    public function __construct(
       CoordinadoraApiController $coordinadoraApi,
       AddressRepository $addressRepository
    ) {
        $this->coordinadoraApi = $coordinadoraApi;
        $this->addressRepository = $addressRepository;
    }

    /**
     * Init data
     *
     * @param Requests array products - items (object)
     * @param Requests array products - total
     * @param Requests shippingAddress
     * @return response
     * String status = success
     * JSON items - (Optional - Default null) - (Each item: name and price)
     * Float price
     * Boolean priceShow
     */
    public function init(Request $request)
    {
        try {
            \Log::info('Module IcommerceCoordinadora: ========= INIT =========');

            $response['status'] = 'error';

            $addressId = $request->shippingAddressId;

            if (is_null($addressId)) {
                \Log::info('Module IcommerceCoordinadora: SHIPPING ADDRESS - NOT FOUND');
                $response['msj'] = 'Debe seleccionar una dirección de entrega';
            } else {
                $address = $this->addressRepository->find($addressId);
                \Log::info('Module IcommerceCoordinadora: SHIPPING ADDRESS ID: '.$addressId);

                $addressResume = $address->first_name.' - '.$address->address_1;
                \Log::info('Module IcommerceCoordinadora: SHIPPING ADDRESS: '.$addressResume);

                $responseCotizacion = $this->coordinadoraApi->cotizacion($request, $address);

                if ($responseCotizacion->status() == 200) {
                    $data = $responseCotizacion->getData()->Cotizador_cotizarResult;

                    //\Log::info('Module IcommerceCoordinadora: ** Response **: '.json_encode($data));
                    \Log::info('Module IcommerceCoordinadora: Flete Total: '.$data->flete_total);

                    $response['status'] = 'success';

                    $response['items'] = null;

                    $response['price'] = $data->flete_total;
                    $response['priceshow'] = true;
                } else {
                    $errorResult = json_decode($responseCotizacion->getContent());
                    $response['msj'] = $errorResult->errors;
                }
            }
        } catch (\Exception $e) {
            //dd("Icommerce Coordinadora Init",$e);
            //Message Error
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        \Log::info('Module IcommerceCoordinadora: RESPONSE: '.json_encode($response));

        \Log::info('Module IcommerceCoordinadora: ========= END =========');

        return response()->json($response, $status ?? 200);
    }

    /*
    *
    */
    public function getCities()
    {
        try {
            $cities = $this->coordinadoraApi->getCities();

            $response = ['data' => $cities];
        } catch (\Exception $e) {
            dd('Icommerce Coordinadora - Get Cities', $e);
            //Message ErrorInit
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }
}
