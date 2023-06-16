<?php

namespace Modules\Icommercestripe\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommercestripe\Repositories\IcommerceStripeRepository;

class EloquentIcommerceStripeRepository extends EloquentBaseRepository implements IcommerceStripeRepository
{
    /**
     * Calculates in Checkout
     */
    public function calculate($parameters, $conf)
    {
        $response['status'] = 'success';

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
                        $response['msj'] = trans('icommerce::common.validation.maximumAmount', ['maximumAmount' => formatMoney($conf->maximumAmount)]);

                        return $response;
                    }
                }
            }
        }

        // Validating Min Amount Order
        if (isset($conf->minimunAmount) && ! empty($conf->minimunAmount)) {
            if (isset($cart->total) || isset($parameters['total'])) {
                if (($cart->total ?? $parameters['total']) < $conf->minimunAmount) {
                    $response['status'] = 'error';
                    $response['msj'] = trans('icommerce::common.validation.minimumAmount', ['minimumAmount' => formatMoney($conf->minimunAmount)]);

                    return $response;
                }
            }
        }

        // Validating Accound Id Destination Requirements to Chargers and Transfers
        if (isset($cart)) {
            //\Log::info("CheckoutValidations|Accound Id Destination Requirements to Chargers and Transfers");

            $stripeApiController = app('Modules\Icommercestripe\Http\Controllers\Api\StripeApiController');
            $paymentMethod = stripeGetConfiguration();

            foreach ($cart->products as $key => $item) {
                //\Log::info("Item Product Organization Id: ".$item->product->organization_id);

                if (! empty($item->product->organization_id)) {
                    $destination = app('Modules\Icommercestripe\Services\StripeService')->getAccountIdByOrganizationId($item->product->organization_id);

                    //\Log::info("Destination: ".json_encode($destination));

                    $account = $stripeApiController->retrieveAccount($paymentMethod->options->secretKey, $destination);

                    // El usuario de connect aun no ha verificado la cuenta pero igual pueden pagar con stripe
                    if (! is_null($destination)) {
                        if (! stripeValidateAccountRequirements($account)) {
                            $response['status'] = 'error';
                            $response['msj'] = trans('icommercestripe::icommercestripes.validation.accountIncomplete');

                            return $response;
                        }
                    }
                }
            }
        }

        return $response;
    }
}
