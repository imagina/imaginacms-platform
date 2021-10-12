<?php

namespace Modules\Isite\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Illuminate\Support\Facades\Storage;

//Exportables
use Maatwebsite\Excel\Facades\Excel;
use Modules\Isite\Exports\RepositoryExport;
use Modules\Isite\Jobs\PDFExport;

class ExportApiController extends BaseApiController
{
  private $disk;
  private $fileTypes;

  public function __construct()
  {
    $this->disk = 'public';
    $this->fileTypes = [
      "pdf" => "pdf",
      "excel" => "xlsx"
    ];
  }

  /**
   * GET A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function show(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      $exportParams = (object)(is_string($request->exportParams) ? json_decode($request->exportParams) : $request->exportParams);
      $fileName = $exportParams->fileName . "-" . $params->user->id . ".".($this->fileTypes[$exportParams->fileType ?? "excel"]);

      //Check if file exist
      $existFile = Storage::disk($this->disk)->exists($fileName);

      //Order response
      $response = !Storage::disk($this->disk)->exists($fileName) ? [] : [
        'path' => route('api.isite.export.download', $fileName),
        'size' => Storage::disk($this->disk)->size($fileName),
        'lastModified' => date('Y-m-d H:i:s', Storage::disk($this->disk)->lastModified($fileName))
      ];
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  //Download file
  public function download($fileName)
  {
    return Storage::disk($this->disk)->download($fileName);
  }

  /**
   * Export users
   *
   * @param $criteria
   * @return mixed
   */
  public function create(Request $request)
  {
   // try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      $exportParams = (is_string($request->exportParams) ? json_decode($request->exportParams) : (object)$request->exportParams);

      switch($exportParams->fileType ?? "excel"){
        case "pdf":
          PDFExport::dispatch($params, $exportParams, $this->disk);
          break;
        case "excel":
  
          if (isset($exportParams->repositoryName)) {//Generate File report by repository
            Excel::store(
              new RepositoryExport($params, $exportParams),
              $exportParams->fileName . "-" . $params->user->id . ".xlsx",
              $this->disk
            );
          } else if (isset($exportParams->exportName)) {//Generate File report by exportClass
            Excel::store(
              app()->makeWith(
                "Modules\\{$exportParams->moduleName}\\Exports\\{$exportParams->exportName}",
                ['params' => $params, 'exportParams' => $exportParams]
              ),
              $exportParams->fileName . "-" . $params->user->id . ".xlsx",
              $this->disk
            );
          }
  
          
          break;
      }
   
  
      
      

      //Response
      $response = ['Export started!'];
  /*  } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }*/

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }
}
