<?php

namespace Modules\Iad\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Icrud\Controllers\BaseCrudController;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iad\Transformers\FieldTransformer;
use Modules\Iad\Http\Requests\CreateFieldRequest;
use Modules\Iad\Http\Requests\UpdateFieldRequest;
use Modules\Iad\Repositories\FieldRepository;

class FieldController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Field $model, FieldRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
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
      $this->validateRequestApi(new CreateFieldRequest((array)$data));

      $fieldsConfig=config()->get('asgard.Iad.config.fields');
      // if (count($fieldsConfig)) {
        foreach ($fieldsConfig as $index => $field) {
          if($field == $data['name']){

            if ($data['name'] == 'mainImage' && Str::contains($data['value'], 'data:image/jpeg;base64')) {
              //Update Iprofile image
              $data['value'] = saveImage($data['value'], "assets/Iad/" . $data['user_id'] . ".jpg");
            }
            //Create item
            $field=$this->modelRepository->create($data);

          }
        }
      // }
      //Response
      $response = ["data" => ""];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = [
        "errors" => $e->getMessage(),
        "line" => $e->getLine(),
        "file" => $e->getFile(),
      ];
      \Log::error($response);
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
      $this->validateRequestApi(new UpdateFieldRequest($data));
      if ($data['name'] == 'mainImage' && Str::contains($data['value'], 'data:image/jpeg;base64')) {
        //Update Iprofile image
        $data['value'] = saveImage($data['value'], "assets/Iad/" . $data['user_id'] . ".jpg");
      }

      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository

      $entity=$this->modelRepository->updateBy($criteria, $data, $params);

      //Response
      $response = ["data" => $entity];
      \DB::commit();//Commit to DataBase
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = [
        "errors" => $e->getMessage(),
        "line" => $e->getLine(),
        "file" => $e->getFile(),
      ];
      \Log::error($response);
    }

    //Return response
    return response()->json($response, $status ?? 200);
  }
  
}
