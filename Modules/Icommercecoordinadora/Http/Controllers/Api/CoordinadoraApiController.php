<?php

namespace Modules\Icommercecoordinadora\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// Base Api
use Modules\Icommerce\Repositories\ShippingMethodRepository;
// Repositories
use Modules\Icommercecoordinadora\Services\CoordinadoraService;
// Services
use Modules\Icommercecoordinadora\Traits\Coordinadora;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class CoordinadoraApiController extends BaseApiController
{
    use Coordinadora;

    private $shippingMethod;

    private $coordinadoraService;

    private $methodConfiguration;

    private $cities;

    public function __construct(
        ShippingMethodRepository $shippingMethod,
        CoordinadoraService $coordinadoraService
    ) {
        $this->shippingMethod = $shippingMethod;
        $this->coordinadoraService = $coordinadoraService;

        $this->methodConfiguration = $this->coordinadoraService->getShippingMethodConfiguration();

        //$this->cities = $this->getCities();
    }

    /**
     * @param Request Array  products  (items,total)
     * @param array address
     * @return response Cotizador
     */
    public function cotizacion(Request $request, $address)
    {
        try {
            //dd($this->clientSoap->__getTypes());
            //dd($this->cities);
            //dd($this->searchCity("aksdjsk"));

            $inforCotizar = $this->coordinadoraService->getInforCotizar($request->products, $this->methodConfiguration, $address);

            $response = $this->initClientSoap()->Cotizador_cotizar(['p' => $inforCotizar]);

            //SoapFault $fault
        } catch (\Exception $e) {
            \Log::error('Module Coordinadora: Cotizacion - Message: '.$e->getMessage());

            //dd("Coordinadora - cotizacion",$e);
            //Message Error
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * @param TESTING
     * @return response Array of Json City
     */
    public function getCities()
    {
        $items = null;
        $result = $this->initClientSoap()->Cotizador_ciudades();

        if (! empty($result->Cotizador_ciudadesResult)) {
            $items = $result->Cotizador_ciudadesResult->item;
        }

        return $items;
    }
}
