<?php

namespace Modules\Iad\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Icrud\Controllers\BaseCrudController;
use Modules\Iad\Entities\AdStatus;
use Modules\Iad\Entities\AdUp;
use Modules\Iad\Repositories\AdUpRepository;

class AdUpApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(AdUp $model, AdUpRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
    }

    /**
     * GET ITEMS
     *
     * @return mixed
     */
    public function indexStatus(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $adStatus = new AdStatus();

            //Response
            $response = ['data' => $adStatus->get()];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }
}
