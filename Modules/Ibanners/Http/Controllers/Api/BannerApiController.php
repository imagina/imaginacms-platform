<?php

namespace Modules\Ibanners\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Ibanners\Http\Requests\CreateBannerRequest;
use Modules\Ibanners\Repositories\BannerRepository;
use Modules\Ibanners\Transformers\BannerApiTransformer as EntityTranformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class BannerApiController extends BaseApiController
{
    private $banner;

    public function __construct(BannerRepository $banner)
    {
        $this->banner = $banner;
    }

   /**
    * GET ITEMS
    *
    * @return mixed
    */
   public function index(Request $request)
   {
       try {
           //Get Parameters from URL.
           $params = $this->getParamsRequest($request);

           //Request to Repository
           $dataEntity = $this->banner->getItemsBy($params);

           //Response
           $response = ['data' => EntityTranformer::collection($dataEntity)];

           //If request pagination add meta-page
           $params->page ? $response['meta'] = ['page' => $this->pageTransformer($dataEntity)] : false;
       } catch (\Exception $e) {
           $status = $this->getStatusError($e->getCode());
           $response = ['errors' => $e->getMessage()];
       }

       //Return response
       return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
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
             $dataEntity = $this->banner->getItem($criteria, $params);

             //Break if no found item
             if (! $dataEntity) {
                 throw new Exception('Item not found', 204);
             }

             //Response
             $response = ['data' => new EntityTranformer($dataEntity)];

             //If request pagination add meta-page
             $params->page ? $response['meta'] = ['page' => $this->pageTransformer($dataEntity)] : false;
         } catch (\Exception $e) {
             $status = $this->getStatusError($e->getCode());
             $response = ['errors' => $e->getMessage()];
         }

         //Return response
         return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
     }

    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get data
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new CreateBannerRequest((array) $data));

            //Create item
            $this->banner->create($data);

            //Response
            $response = ['data' => ''];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }
        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * UPDATE ITEM
     *
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            //Get data
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new CreateBannerRequest((array) $data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            $dataEntity = $this->banner->getItem($criteria, $params);

            if (! $dataEntity) {
                throw new Exception('Item not found', 204);
            }

            //Request to Repository
            $this->banner->update($dataEntity, $data);

            //Response
            $response = ['data' => 'Item Updated'];
            \DB::commit(); //Commit to DataBase
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    private function addIbannersId(Ibanners $position, FormRequest $request): array
    {
        return array_merge($request->all(), ['position_id' => $position->id]);
    }

    /**
     * DELETE A ITEM
     *
     * @return mixed
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);
            //Delete data
            $this->banner->deleteBy($criteria, $params);
            //Response
            $response = ['data' => ''];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response, $status ?? 200);
    }
}
