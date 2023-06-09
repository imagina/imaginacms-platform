<?php

namespace Modules\Icommercecoordinadora\Services;

use Modules\Icommerce\Repositories\ShippingMethodRepository;

class CoordinadoraService
{
    private $shippingMethod;

    /*
    *
    */
    public function __construct(
       ShippingMethodRepository $shippingMethod
    ) {
        $this->shippingMethod = $shippingMethod;
    }

    /*
    *
    */
    public function getShippingMethodConfiguration()
    {
        $shippingName = config('asgard.icommercecoordinadora.config.shippingName');
        $attribute = ['name' => $shippingName];
        $shippingMethod = $this->shippingMethod->findByAttributes($attribute);

        return $shippingMethod;
    }

    /**
     * @param Request Array  products(items,total)
     * @return array
     */
    public function getInforCotizar($products, $methodConfig, $address): array
    {
        // Examples
        // Origen - Ibague -73001000
        // Destino - Bogota - 54001000

        $city = app('Modules\Ilocations\Repositories\CityRepository')->where('id', $address->city_id)->first();

        if (! isset($city->name)) {
            throw new \Exception('City not found', 404);
        }

        \Log::info('Module IcommerceCoordinadora: CITY: '.$city->name.' - Code: '.$city->code);

        $inforCotizar = [
            'nit' => null, // Opcional
            'div' => null, // Opcional
            'cuenta' => 3, //Codigo de la cuenta,1=Cuenta Corriente,3=Flete Pago
            'producto' => '0', //Codigo de producto.
            'nivel_servicio' => null,
            'origen' => $methodConfig->options->cityOrigin, //COD dane - Ciudad
            'destino' => $city->code, //COD dane - Ciudad
            'valoracion' => $products['total'], // Valor declarado del envio
            'detalle' => $this->getDetalleEmpaques($products),
            'apikey' => $methodConfig->options->apiKey,
            'clave' => $methodConfig->options->password,
        ];

        return $inforCotizar;
    }

    public function getDetalleEmpaques($products)
    {
        $detalleEmpaques = [];

        $items = json_decode($products['items']);

        foreach ($items as $key => $item) {
            array_push($detalleEmpaques, [
                'ubl' => null, //Código de la UBL, 0=>Automatica, 1=>Mercancia
                'alto' => $item->height,
                'ancho' => $item->width,
                'largo' => $item->length,
                'peso' => $item->weight,
                'unidades' => $item->quantity,
            ]);
        }

        //\Log::info('Module IcommerceCoordinadora: Empaques: '.json_encode($detalleEmpaques));

        return $detalleEmpaques;
    }
}
