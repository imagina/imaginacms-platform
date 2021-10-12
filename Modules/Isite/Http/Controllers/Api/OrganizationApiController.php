<?php

namespace Modules\Isite\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model Repository
use Modules\Isite\Repositories\OrganizationRepository;
//Model Requests
use Modules\Isite\Http\Requests\CreateOrganizationRequest;
use Modules\Isite\Http\Requests\UpdateOrganizationRequest;
//Transformer
use Modules\Isite\Transformers\OrganizationTransformer;

class OrganizationApiController extends BaseCrudController
{
  public $modelRepository;

  public function __construct(OrganizationRepository $modelRepository)
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
    return new CreateOrganizationRequest($modelData);
  }

  /**
   * Return request to create model
   *
   * @param $modelData
   * @return false
   */
  public function modelUpdateRequest($modelData)
  {
    return new UpdateOrganizationRequest($modelData);
  }

  /**
   * Return model collection transformer
   *
   * @param $data
   * @return mixed
   */
  public function modelCollectionTransformer($data)
  {
    return OrganizationTransformer::collection($data);
  }

  /**
   * Return model transformer
   *
   * @param $data
   * @return mixed
   */
  public function modelTransformer($data)
  {
    return new OrganizationTransformer($data);
  }
}