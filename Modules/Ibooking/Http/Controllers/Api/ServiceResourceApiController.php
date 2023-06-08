<?php

namespace Modules\Ibooking\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model Repository
use Modules\Ibooking\Repositories\ServiceResourceRepository;
//Model Requests
use Modules\Ibooking\Http\Requests\CreateServiceResourceRequest;
use Modules\Ibooking\Http\Requests\UpdateServiceResourceRequest;
//Transformer
use Modules\Ibooking\Transformers\ServiceResourceTransformer;

class ServiceResourceApiController extends BaseCrudController
{
  public $modelRepository;

  public function __construct(ServiceResourceRepository $modelRepository)
  {
    $this->modelRepository = $modelRepository;
  }
  
  /**
   * Return request to create model
   *
   * @param $modelData
   * @return false
   */
  public function modelCreateRequest($modelData)
  {
    return new CreateServiceResourceRequest($modelData);
  }

  /**
   * Return request to create model
   *
   * @param $modelData
   * @return false
   */
  public function modelUpdateRequest($modelData)
  {
    return new UpdateServiceResourceRequest($modelData);
  }

  /**
   * Return model collection transformer
   *
   * @param $data
   * @return mixed
   */
  public function modelCollectionTransformer($data)
  {
    return ServiceResourceTransformer::collection($data);
  }

  /**
   * Return model transformer
   *
   * @param $data
   * @return mixed
   */
  public function modelTransformer($data)
  {
    return new ServiceResourceTransformer($data);
  }
}