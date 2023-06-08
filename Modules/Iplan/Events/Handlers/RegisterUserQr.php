<?php


namespace Modules\Iplan\Events\Handlers;


class RegisterUserQr
{
    function handle($event){
        $user = $event->user;
        if(is_module_enabled('Qreable')){
            $enableQR = setting('iplan::enableQr', null, '0');
            if(!empty($enableQR) && $enableQR == '1'){
                $qrService = app('Modules\Qreable\Services\QrService');
                $qrService->addQr($user, route('plans.validateUserSubscriptions',[$user->id]), 'subscriptions');
            }
        }
    }
}
