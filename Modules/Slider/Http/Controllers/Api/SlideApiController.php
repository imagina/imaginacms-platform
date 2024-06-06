<?php

namespace Modules\Slider\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Http\Requests\CreateSlideRequest;
use Modules\Slider\Repositories\SlideApiRepository;
use Modules\Slider\Transformers\SlideApiTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class SlideApiController extends BaseApiController
{

  private $slideApi;

  public function __construct(SlideApiRepository $sliderApi)
  {
    $this->slideApi = $sliderApi;
  }

  /**
   * Get slide by parameters
   *
   * @param Request $request
   */
  public function index(Request $request){
    try {
      //Get Parameters from URL.
      $p = $this->getParamsRequest($request, []);

      //Request to Repository
      $slides = $this->slideApi->index($p->page, $p->take, $p->filter, $p->include);

      //Response
      $response = ["data" => SlideApiTransformer::collection($slides)];

      //If request pagination add meta-page
      $p->page ? $response["meta"] = ["page" => $this->pageTransformer($slides)] : false;
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
   * Show slide by id
   */
  public function show($id, Request $request)
  {
    try {
      //Get Parameters from URL.
      $p = $this->getParamsRequest($request, []);

      //Request to Repository
      $slider = $this->slideApi->show($id,$p->include);

      //Response
      $response = [
        "data" => is_null($slider) ?
          false : new SlideApiTransformer($slider)
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
    public function store(Slider $slider, CreateSlideRequest $request)
    {
        try {
            $this->slide->create($this->addSliderId($slider, $request));
            $response = [
                "data" => "Slide Created"
            ];
        }catch(\Exception $e){
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
            //$this->validateRequestApi(new CustomRequest((array)$data));
      
            //Create item
            $this->slideApi->create($data);
      
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
          try {
            //Get data
            $data = $request->input('attributes');
      
            //Validate Request
            //$this->validateRequestApi(new CustomRequest((array)$data));
      
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);
      
            //Request to Repository
            $this->slideApi->updateBy($criteria, $data, $params);
      
            //Response
            $response = ["data" => 'Item Updated'];
            \DB::commit();//Commit to DataBase
          } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
          }
          
          //Return response
          return response()->json($response, $status ?? 200);
        }

    /**
     * @param  Slider $slider
     * @param  \Illuminate\Foundation\Http\FormRequest $request
     * @return array
     */
    private function addSliderId(Slider $slider, FormRequest $request)
    {
        return array_merge($request->all(), ['slider_id' => $slider->id]);
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
            $this->slideApi->deleteBy($criteria, $params);
      
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
