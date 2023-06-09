<?php

namespace Modules\Icommercecredibanco\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommercecredibanco\Repositories\IcommerceCredibancoRepository;

class EloquentIcommerceCredibancoRepository extends EloquentBaseRepository implements IcommerceCredibancoRepository
{
    public function calculate($parameters, $conf)
    {
        // Search Cart
        if (isset($parameters['cartId'])) {
            $cartRepository = app('Modules\Icommerce\Repositories\CartRepository');
            $cart = $cartRepository->find($parameters['cartId']);
        }

        //validating Auth user if exist in the excluded Users For Maximum Amount
        $excludeUser = false;
        $authUser = \Auth::user();
        if (isset($authUser->id) && isset($conf->excludedUsersForMaximumAmount) && ! empty($conf->excludedUsersForMaximumAmount)) {
            if (in_array($authUser->id, $conf->excludedUsersForMaximumAmount)) {
                $excludeUser = true;
            }
        }

        //if there have not to exclude any user
        if (! $excludeUser) {
            if (isset($conf->maximumAmount) && ! empty($conf->maximumAmount)) {
                if (isset($cart->total) || isset($parameters['total'])) {
                    if (($cart->total ?? $parameters['total']) > $conf->maximumAmount) {
                        $response['status'] = 'error';

                        // Items
                        $response['items'] = trans('icommercecredibanco::icommercecredibancos.validation.maximumAmount', ['maximumAmount' => formatMoney($conf->maximumAmount)]);
                        // Msj
                        $response['msj'] = trans('icommercecredibanco::icommercecredibancos.validation.maximumAmount', ['maximumAmount' => formatMoney($conf->maximumAmount)]);
                        // Price
                        $response['price'] = 0;
                        $response['priceshow'] = false;

                        return $response;
                    }
                }
            }
        }

        $response['status'] = 'success';

        // Items
        $response['items'] = null;

        // Price
        $response['price'] = 0;
        $response['priceshow'] = false;

        return $response;
    }
}
