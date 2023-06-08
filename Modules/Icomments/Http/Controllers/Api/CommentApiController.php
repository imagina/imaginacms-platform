<?php

namespace Modules\Icomments\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icomments\Entities\Comment;
use Modules\Icomments\Repositories\CommentRepository;

use Illuminate\Http\Request;
//Default transformer
use Modules\Core\Icrud\Transformers\CrudResource;

class CommentApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;
  public $commentService;

  public function __construct(Comment $model, CommentRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
    $this->commentService = app("Modules\Icomments\Services\CommentService");
  }

  /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            $modelData = $request->input('attributes') ?? [];//Get data  
            
            //Validate Request
            if (isset($this->model->requestValidation['create'])) {
              $this->validateRequestApi(new $this->model->requestValidation['create']($modelData));
            }

            // Model if exist
            // Model Data (attributes)
            $model = $this->commentService->create(null,$modelData);

            //Response
            $response = ["data" => CrudResource::transformData($model)];
            \DB::commit(); //Commit to Data Base
            
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["messages" => [["message" => $e->getMessage(), "type" => "error"]]];
        }
        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }



}
