<?php

use Modules\Ipay\Entities\Config;

if (!function_exists('ipay_config')) {

    function ipay_config($templates)
    {

        $ipay = Config::query()->first();

        if ($ipay) {
            $view = View::make($templates)
                ->with([
                    'ipay' => $ipay,
                ]);
            return $view->render();
        }
    }


}