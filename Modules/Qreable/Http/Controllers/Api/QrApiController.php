<?php

namespace Modules\Qreable\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Qreable\Repositories\QredRepository;

class QrApiController extends BaseApiController
{
    private $qr;

    public function __construct(QredRepository $qr)
    {
        $this->qr = $qr;
    }

    /**
     * GET A ITEM
     *
     * @return mixed
     */
    public function show($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $qr = $this->qr->getItem($criteria, $params);

            //Break if no found item
            if (! $qr) {
                throw new \Exception('Item not found', 404);
            }

            //Redirect to
            return redirect()->to($qr->redirect);
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];

            return response()->json($response, $status ?? 200);
        }
    }
}
