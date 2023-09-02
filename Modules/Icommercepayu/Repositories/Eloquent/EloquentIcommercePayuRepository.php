<?php

namespace Modules\Icommercepayu\Repositories\Eloquent;

use Illuminate\Support\Str;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommercepayu\Repositories\IcommercePayuRepository;

class EloquentIcommercePayuRepository extends EloquentBaseRepository implements IcommercePayuRepository
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

        return $response;
    }

    /**
     * Update Payment Method
     */
    public function update($model, $data)
    {
        //Get data
        $requestimage = $data['mainimage'];
        $requestmerchantId = $data['merchantId'];
        $requestapilogin = $data['apiLogin'];
        $requestapiKey = $data['apiKey'];
        $requestaccountId = $data['accountId'];
        $requestmode = $data['mode'];
        $requesttest = $data['test'];

        // Delete attributes
        unset($data['mainimage']);
        unset($data['merchantId']);
        unset($data['apiLogin']);
        unset($data['apiKey']);
        unset($data['accountId']);
        unset($data['mode']);
        unset($data['test']);

        // Image
        if (($requestimage == null) || (! empty($requestimage))) {
            $requestimage = $this->saveImage($requestimage, 'assets/icommercepayu/1.jpg');
        }
        $options['mainimage'] = $requestimage;

        // Extra data
        $options['merchantId'] = $requestmerchantId;
        $options['apiLogin'] = $requestapilogin;
        $options['apiKey'] = $requestapiKey;
        $options['accountId'] = $requestaccountId;
        $options['mode'] = $requestmode;
        $options['test'] = $requesttest;

        // Extra data in Options
        $data['options'] = $options;

        $model->update($data);

        return $model;
    }

    /**
     * Save Image
     *
     * @param    $destination
     */
    public function saveImage($value, $destination_path)
    {
        $disk = 'publicmedia';
        //Defined return.
        if (ends_with($value, '.jpg')) {
            return $value;
        }
        // if a base64 was sent, store it in the db
        if (Str::startsWith($value, 'data:image')) {
            // 0. Make the image
            $image = \Image::make($value);
            // resize and prevent possible upsizing
            $image->resize(config('asgard.iblog.config.imagesize.width'), config('asgard.iblog.config.imagesize.height'), function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            if (config('asgard.iblog.config.watermark.activated')) {
                $image->insert(config('asgard.iblog.config.watermark.url'), config('asgard.iblog.config.watermark.position'), config('asgard.iblog.config.watermark.x'), config('asgard.iblog.config.watermark.y'));
            }
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path, $image->stream('jpg', '80'));
            // Save Thumbs
            \Storage::disk($disk)->put(
                str_replace('.jpg', '_mediumThumb.jpg', $destination_path),
                $image->fit(config('asgard.iblog.config.mediumthumbsize.width'), config('asgard.iblog.config.mediumthumbsize.height'))->stream('jpg', '80')
            );
            \Storage::disk($disk)->put(
                str_replace('.jpg', '_smallThumb.jpg', $destination_path),
                $image->fit(config('asgard.iblog.config.smallthumbsize.width'), config('asgard.iblog.config.smallthumbsize.height'))->stream('jpg', '80')
            );
            // 3. Return the path
            return $destination_path;
        }
        // if the image was erased
        if ($value == null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($destination_path);
            // set null in the database column
            return null;
        }
    }

    /**
     * Generate Signature (from function ok)
     *
     * @param  string  $apikey
     * @return $signature
     */
    public function signatureGeneration($apiKey, $merchantId, $referenceSale, $new_value, $currency, $state_pol)
    {
        $split = explode('.', $new_value);
        $decimals = $split[1];

        if ($decimals % 10 == 0) {
            $value = number_format($new_value, 1, '.', '');
        } else {
            $value = $new_value;
        }

        $signature_local = $apiKey.'~'.$merchantId.'~'.$referenceSale.'~'.$value.'~'.$currency.'~'.$state_pol;

        $signature_md5 = md5($signature_local);

        return $signature_md5;
    }

    /**
     * Encript url to reedirect
     *
     * @return $url
     */
    public function encriptUrl($orderID, $transactionID, $currencyID)
    {
        $url = "{$orderID}-{$transactionID}-{$currencyID}-".time();
        $encrip = base64_encode($url);

        return  $encrip;
    }

    /**
     * Decript url to get data
     */
    public function decriptUrl($eUrl)
    {
        $decrip = base64_decode($eUrl);
        $infor = explode('-', $decrip);

        return  $infor;
    }
}
