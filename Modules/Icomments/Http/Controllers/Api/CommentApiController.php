<?php

namespace Modules\Icomments\Http\Controllers\Api;

use Illuminate\Http\Request;
//Model
use Modules\Core\Icrud\Controllers\BaseCrudController;
use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Icomments\Entities\Comment;
//Default transformer
use Modules\Icomments\Repositories\CommentRepository;

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
       */
      public function create(Request $request)
      {
          \DB::beginTransaction();
          try {
              $modelData = $request->input('attributes') ?? []; //Get data

              //Validate Request
              if (isset($this->model->requestValidation['create'])) {
                  $this->validateRequestApi(new $this->model->requestValidation['create']($modelData));
              }

              // Model if exist
              // Model Data (attributes)
              $model = $this->commentService->create(null, $modelData);

              //Response
              $response = ['data' => CrudResource::transformData($model)];
              \DB::commit(); //Commit to Data Base
          } catch (\Exception $e) {
              \DB::rollback(); //Rollback to Data Base
              $status = $this->getStatusError($e->getCode());
              $response = ['messages' => [['message' => $e->getMessage(), 'type' => 'error']]];
          }
          //Return response
          return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
      }
}
