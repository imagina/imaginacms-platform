<?php

namespace Modules\Ibooking\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model Repository
use Modules\Ibooking\Http\Requests\CreateServiceResourceRequest;
//Model Requests
use Modules\Ibooking\Http\Requests\UpdateServiceResourceRequest;
use Modules\Ibooking\Repositories\ServiceResourceRepository;
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
     * @return false
     */
    public function modelCreateRequest($modelData): bool
    {
        return new CreateServiceResourceRequest($modelData);
    }

    /**
     * Return request to create model
     *
     * @return false
     */
    public function modelUpdateRequest($modelData): bool
    {
        return new UpdateServiceResourceRequest($modelData);
    }

    /**
     * Return model collection transformer
     *
     * @return mixed
     */
    public function modelCollectionTransformer($data)
    {
        return ServiceResourceTransformer::collection($data);
    }

    /**
     * Return model transformer
     *
     * @return mixed
     */
    public function modelTransformer($data)
    {
        return new ServiceResourceTransformer($data);
    }
}
