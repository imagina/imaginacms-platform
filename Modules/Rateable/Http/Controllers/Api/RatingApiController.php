<?php

namespace Modules\Rateable\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Rateable\Entities\Rating;
use Modules\Rateable\Repositories\RatingRepository;

use Illuminate\Http\Request;
//Default transformer
use Modules\Core\Icrud\Transformers\CrudResource;

class RatingApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Rating $model, RatingRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }


  /**
   * Controller to create model
   *
   * @param Request $request
   * @return mixed
   */
  public function create(Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get model data
      $modelData = $request->input('attributes') ?? [];

      //Validate Request
      if (isset($this->model->requestValidation['create'])) {
        $this->validateRequestApi(new $this->model->requestValidation['create']($modelData));
      }

      //Create model
      $model = $this->modelRepository->create($modelData);

      //Create a Comment for this Rating
      if(isset($modelData['comment'])){
        $createdComment = app('Modules\Icomments\Services\CommentService')->create($model,$modelData['comment']);
      }

      //Response
      $response = ["data" => CrudResource::transformData($model)];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }




}
