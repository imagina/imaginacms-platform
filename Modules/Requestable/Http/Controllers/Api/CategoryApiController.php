<?php

namespace Modules\Requestable\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Requestable\Entities\Category;
use Modules\Requestable\Repositories\CategoryRepository;
use Modules\Iforms\Repositories\FieldRepository;

use Illuminate\Http\Request;

// Transformers
use Modules\Requestable\Transformers\FormFieldTransformer;

class CategoryApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;
  public $fieldRepository;

  public function __construct(
    Category $model, 
    CategoryRepository $modelRepository,
    FieldRepository $fieldRepository
  ){
    $this->model = $model;
    $this->modelRepository = $modelRepository;
    $this->fieldRepository = $fieldRepository;
  }

  /**
  * Get form field to Category
  * @param $criteria (category id)
  * @param $request
  */
  public function getFormFields($criteria, Request $request){
    
  
    \DB::beginTransaction(); //DB Transaction
    try {

      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      // Search
      $model = $this->modelRepository->getItem($criteria);

      //Break if no found item
      if (!$model) throw new \Exception('Item not found', 404);

      // Get form from Model
      $form = $model->form;
     
      if(!is_null($form->id)){

        $params->filter->formId = $form->id;

        $data = $this->fieldRepository->getItemsBy($params);
        
        if(!is_null($data) && count($data)>0){

          $response = ["data" => FormFieldTransformer::collection($data)];

          //If request pagination add meta-page
          $params->page ? $response["meta"] = ["page" => $this->pageTransformer($data)] : false;
        }else{
          throw new \Exception(trans("requestable::categories.messages.phoneFieldError",["fieldType" => $params->filter->type, "formTitle" => $form->title, "formFieldsUrl" => url("/iadmin/#/form/fields/$form->id/")]), 400);
        }

      }
      
      
    } catch (\Exception $e) {
      //dd($e);
      $status = $this->getStatusError($e->getCode());
      $response = ["messages" => [["message" => $e->getMessage(), "type" => "error", "timeOut" => 10000 ]]];
  
    }
    
    //Return response
    return response()->json($response ?? null, $status ?? 200);
   
  }

}
