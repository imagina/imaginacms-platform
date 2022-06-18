<?php

namespace Modules\Media\Http\Controllers\Api\NewApi;

// Requests & Response
use Modules\Media\Entities\File;
use Modules\Media\Events\FileWasUploaded;
use Modules\Media\Http\Requests\LogRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers

use Modules\Media\Http\Requests\UpdateMediaRequest;
use Modules\Media\Http\Requests\UploadMediaRequest;
use Modules\Media\Image\Imagy;
use Modules\Media\Services\FileService;
use Modules\Media\Transformers\NewTransformers\MediaTransformer;

// Repositories
use Modules\Media\Repositories\FileRepository;

class MediaApiController extends BaseApiController
{
  private $file;
  private $fileService;
  /**
   * @var Imagy
   */
  private $imagy;
  
  public function __construct(FileRepository $file, FileService $fileService, Imagy $imagy)
  {
    
    $this->file = $file;
    $this->fileService = $fileService;
    $this->imagy = $imagy;
    
  }
  
  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function index(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      
      //Request to Repository
      $dataEntity = $this->file->getItemsBy($params);
      
      //Response
      $response = [
        "data" => MediaTransformer::collection($dataEntity)
      ];
      
      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response, $status ?? 200);
  }
  
  
  /**
   * GET A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function show($criteria, Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      
      //Request to Repository
      $dataEntity = $this->file->getItem($criteria, $params);
      
      //Break if no found item
      if (!$dataEntity) throw new \Exception('Item not found', 404);
      
      //Response
      $response = ["data" => new MediaTransformer($dataEntity)];
      
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
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
   
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
  
      $disk = (in_array($request->get('disk'),array_keys(config('filesystems.disks'))))? $request->get('disk') : null;
     
      $file = $request->file('file');
      $contentType = $request["Content-Type"];
      //return [$contentType];
    
      $savedFile = $this->fileService->store($file, $request->get('parent_id'),$disk);
  
      if (is_string($savedFile)) throw new \Exception($savedFile, 409);
      
      event(new FileWasUploaded($savedFile));
      
      //Response
      $response = ["data" => new MediaTransformer($savedFile)];
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
      $this->validateRequestApi(new UpdateMediaRequest((array)$data));
      
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      
      //Request to Repository
      $this->file->updateBy($criteria, $data, $params);
      
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
   * DELETE A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function delete(File $file, Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get params
      $params = $this->getParamsRequest($request);
      
      //call Method delete
      $this->imagy->deleteAllFor($file);
      $this->file->destroy($file);
      
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
  
  /**
   * DELETE A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function downloadFile( $path, Request $request)
  {
    return Storage::response("storage/assets/media/$path");
  }
  
}
