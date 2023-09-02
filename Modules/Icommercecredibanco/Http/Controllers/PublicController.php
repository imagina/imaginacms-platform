<?php

namespace Modules\Icommercecredibanco\Http\Controllers;

// Requests & Response
use Illuminate\Http\Request;
// Base
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Icommercecredibanco\Http\Controllers\Api\IcommerceCredibancoApiController;
//Others
use Modules\Setting\Contracts\Setting;

class PublicController extends BasePublicController
{
    private $setting;

    private $credibancoApiController;

    public function __construct(
        Setting $setting,
        IcommerceCredibancoApiController $credibancoApiController
    ) {
        $this->setting = $setting;
        $this->credibancoApiController = $credibancoApiController;
    }

    /**
     * Show Voucher
     */
    public function voucherShow(Request $request)
    {
        \Log::info('Module Icommercecredibanco: VoucherShow - '.time());

        try {
            $response = $this->credibancoApiController->getUpdateOrder($request);

            $data = ($response->getData())->data;
            $commerceName = $this->setting->get('core::site-name');
            $tpl = 'icommercecredibanco::frontend.voucher';

            return view($tpl, compact('data', 'commerceName'));
        } catch(\Exception $e) {
            echo 'Ooops, ha ocurrido un error al mostrar el voucher, comuniquese con el administrador';

            \Log::error('Module Icommercecredibanco - voucherShow: Message: '.$e->getMessage());
            \Log::error('Module Icommercecredibanco - voucherShow: Code: '.$e->getCode());
        }
    }
}
