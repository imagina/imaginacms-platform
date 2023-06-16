<?php

namespace Modules\Icommerceagree\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// Base Api
use Modules\Icommerce\Repositories\ShippingMethodRepository;
// Repositories
use Modules\Icommerceagree\Repositories\IcommerceAgreeRepository;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class IcommerceAgreeApiController extends BaseApiController
{
    private $icommerceagree;

    private $shippingMethod;

    public function __construct(
        IcommerceAgreeRepository $icommerceagree,
        ShippingMethodRepository $shippingMethod
    ) {
        $this->icommerceagree = $icommerceagree;
        $this->shippingMethod = $shippingMethod;
    }

    /**
     * Init data
     *
     * @param Requests request
     * @param Requests array products - items (object)
     * @param Requests array products - total
     * @return mixed
     */
    public function init(Request $request)
    {
        try {
            // Configuration
            $shippingName = config('asgard.icommerceagree.config.shippingName');
            $attribute = ['name' => $shippingName];
            $shippingMethod = $this->shippingMethod->findByAttributes($attribute);

            $response = $this->icommerceagree->calculate($request->all(), $shippingMethod->options);
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
