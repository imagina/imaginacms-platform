<?php

namespace Modules\Icommercefreeshipping\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// Base Api
use Modules\Icommerce\Repositories\ShippingMethodRepository;
// Repositories
use Modules\Icommercefreeshipping\Repositories\IcommerceFreeshippingRepository;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class IcommerceFreeshippingApiController extends BaseApiController
{
    private $icommerceFreeshipping;

    private $shippingMethod;

    public function __construct(
        IcommerceFreeshippingRepository $icommerceFreeshipping,
        ShippingMethodRepository $shippingMethod
    ) {
        $this->icommerceFreeshipping = $icommerceFreeshipping;
        $this->shippingMethod = $shippingMethod;
    }

    /**
     * Init data
     *
     * @param Requests request
     * @param Requests array products - items (object)
     * @param Requests array products - total
     * @param Requests array options - countryCode
     * @return mixed
     */
    public function init(Request $request)
    {
        try {
            // Configuration
            $shippingName = config('asgard.icommercefreeshipping.config.shippingName');
            $attribute = ['name' => $shippingName];
            $shippingMethod = $this->shippingMethod->findByAttributes($attribute);

            $response = $this->icommerceFreeshipping->calculate($request->all(), $shippingMethod->options);
        } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }
}
