<?php

namespace Modules\Isite\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Icrud\Controllers\BaseCrudController;

//Model
use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Isite\Entities\Revision;
use Modules\Isite\Repositories\RevisionRepository;

class RevisionApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Revision $model, RevisionRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }

  public function show($criteria, Request $request)
  {
    try {
      //Get Parameters from request
      $params = $this->getParamsRequest($request);

      //Request data to Repository
      $model = $this->modelRepository->getItem($criteria, $params);

      //Throw exception if no found item
      if (!$model) throw new Exception('Item not found', 204);

      //Using the show endpoint to get the "revisioned" entity model instead of the Revision Entity
      if (isset($params->filter->entity)) {
        switch ($params->filter->entity) {
          case "newValue":
          default:
            $entity = new $model->revisionable_type(json_decode($model->new_value, true));
            break;
          case "oldValue":
            $entity = new $model->revisionable_type(json_decode($model->old_value, true));
            break;
        }
        //Entity Response
        $response = new $entity->transformer($entity);

      } else {
        //Response
        $response = ["data" => CrudResource::transformData($model)];

      }
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }
}
