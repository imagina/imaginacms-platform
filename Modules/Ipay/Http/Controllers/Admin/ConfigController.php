<?php

namespace Modules\Ipay\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Ipay\Entities\Config;
use Modules\Ipay\Http\Requests\IpayRequest;
use Modules\User\Contracts\Authentication;

class ConfigController extends AdminBaseController
{
    /**
     * @var ConfigRepository
     */
    private $auth;

    public function __construct(Authentication $auth)
    {
        parent::__construct();
        $this->auth = $auth;
    }

    public function index()
    {
        //dd('hg');
        $regconfig = new Config;
        $regconfig = $regconfig::first();

        if (count($regconfig)) {
            $status = $regconfig->status;
            $title = $regconfig->title;
            $merchantid = $regconfig->merchantid;
            $accountid = $regconfig->accountid;
            $apikey = $regconfig->apikey;
            $mode = $regconfig->mode;
            $replyurl = $regconfig->replyurl;
            $confirmationurl = $regconfig->confirmationurl;
            $currency = $regconfig->currency;
        } else {
            $status = '';
            $title = '';
            $merchantid = '';
            $accountid = '';
            $apikey = '';
            $mode = '';
            $replyurl = '';
            $confirmationurl = '';
            $currency = '';
        }

        $data = [
            'status' => $status,
            'title' => $title,
            'merchantid' => $merchantid,
            'accountid' => $accountid,
            'apikey' => $apikey,
            'mode' => $mode,
            'replyurl' => $replyurl,
            'confirmationurl' => $confirmationurl,
            'currency' => $currency,
        ];
        //dd($data);
        return view('ipay::admin.index', $data);
    }

    /**
     * Url Boton
     * Prueba: https://sandbox.gateway.payulatam.com/ppp-web-gateway/
     * Produccion: https://gateway.payulatam.com/ppp-web-gateway/
     */
    public function update(IpayRequest $request)
    {
        $regconfig = new Config;
        if (count($regconfig::first())) {
            $regconfig = $regconfig::first();
        }

        $regconfig->status = $request->input('status');
        $regconfig->title = $request->input('title');
        $regconfig->merchantid = $request->input('merchantid');
        $regconfig->accountid = $request->input('accountid');
        $regconfig->apikey = $request->input('apikey');

        $regconfig->mode = $request->input('mode');
        $regconfig->replyurl = $request->input('replyurl');
        $regconfig->confirmationurl = $request->input('confirmationurl');
        $regconfig->currency = $request->input('currency');
        $regconfig->options = $request->input('options');

        if ($regconfig->save()) {
            return redirect('backend/');
        } else {
            return back()->with('error', 'Error al enviar los datos.');
        }
    }
}
