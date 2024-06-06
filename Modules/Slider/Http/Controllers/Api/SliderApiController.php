<?php

namespace Modules\Slider\Http\Controllers\Api;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Slider\Http\Requests\UpdateSliderRequest;
use Modules\Slider\Repositories\Eloquent\EloquentSliderApiRepository;
use Modules\Slider\Services\SlideOrderer;
use Modules\Slider\Repositories\SliderApiRepository;
use Modules\Slider\Transformers\SliderApiTransformer;

class SliderApiController extends BaseApiController
{
  /**
   * @var Repository
   */
  private $cache;
  /**
   * @var SlideOrderer
   */
  private $slideOrderer;
  /**
   * @var EloquentSliderApiRepository
   */
  private $slider;

  public function __construct(SliderApiRepository $slider, SlideOrderer $slideOrderer)
  {
    $this->slider = $slider;
    $this->slideOrderer = $slideOrderer;
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
        $sliders = $this->slider->getItemsBy($params);
  
        //Response
        $response = [
          "data" => SliderApiTransformer::collection($sliders)
        ];
  
        //If request pagination add meta-page
        $params->page ? $response["meta"] = ["page" => $this->pageTransformer($sliders)] : false;
      } catch (\Exception $e) {
        $status = $this->getStatusError($e->getCode());
        $response = ["errors" => $e->getMessage()];
      }
  
      //Return response
      return response()->json($response, $status ?? 200);
    }
    
 

  /**
   * Show slide by id
   */
  public function show($criteria,Request $request)
  {
    try {
      //Request to Repository

      $params = $this->getParamsRequest($request);
      $slider = $this->slider->getItem($criteria,$params);

      //Response
      $response = [
        "data" => is_null($slider) ?
          false : new SliderApiTransformer($slider)
      ];
    } catch (\Exception $e) {
      //Message Error
      $status = 500;
      $response = [
        "errors" => $e->getMessage()
      ];
    }

    return response()->json($response, $status ?? 200);
  }
  
    /**
       * CREATE A ITEM
       *
       * @param Request $request
       * @return mixed
       */
      public function create(Request $request)
      {
        \DB::beginTransaction();
        try {
         //Get data
          $data = $request->input('attributes');
          
          //Validate Request
         // $this->validateRequestApi(new CustomRequest((array)$data));
    
          //Create item
          $this->slider->create($data);
    
          //Response
          $response = ["data" => ""];
          \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
          \DB::rollback();//Rollback to Data Base
          $status = $this->getStatusError($e->getCode());
          $response = ["errors" => $e->getMessage()];
        }
        //Return response
        return response()->json($response, $status ?? 200);
      }
    /**
       * UPDATE ITEM
       *
       * @param $criteria
       * @param Request $request
       * @return mixed
       */
      public function update($criteria, Request $request)
      {
        \DB::beginTransaction(); //DB Transaction
     //   try {
          //Get data
          $data = $request->input('attributes');
    
          //Validate Request
         // $this->validateRequestApi(new UpdateSliderRequest((array)$data));
    
          //Get Parameters from URL.
          $params = $this->getParamsRequest($request);
    
          //Request to Repository
          $this->slider->updateBy($criteria, $data, $params);
  
          if(isset($data["slides"])){
            $this->slideOrderer->handle(json_encode($data["slides"]));
          }
    
          //Response
          $response = ["data" => 'Item Updated'];
          \DB::commit();//Commit to DataBase
       /* } catch (\Exception $e) {
          \DB::rollback();//Rollback to Data Base
          $status = $this->getStatusError($e->getCode());
          $response = ["errors" => $e->getMessage()];
        }*/
        
        //Return response
        return response()->json($response, $status ?? 200);
      }
      
      
        /**
           * DELETE A ITEM
           *
           * @param $criteria
           * @return mixed
           */
          public function delete($criteria, Request $request)
          {
            \DB::beginTransaction();
            try {
              //Get params
              $params = $this->getParamsRequest($request);
        
              //call Method delete
              $this->slider->deleteBy($criteria, $params);
        
              //Response
              $response = ["data" => ""];
              \DB::commit();//Commit to Data Base
            } catch (\Exception $e) {
              \DB::rollback();//Rollback to Data Base
              $status = $this->getStatusError($e->getCode());
              $response = ["errors" => $e->getMessage()];
            }
        
            //Return response
            return response()->json($response, $status ?? 200);
          }
      
}
