<?php

namespace Modules\Media\Http\Controllers\Api\NewApi;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
// Transformers

use Modules\Media\Image\Imagy;
use Modules\Media\Repositories\FileRepository;
use Modules\Media\Repositories\FolderRepository;
// Repositories
use Modules\Media\Services\Movers\Mover;

class BatchApiController extends BaseApiController
{
    /**
     * @var FileRepository
     */
    private $file;

    /**
     * @var FolderRepository
     */
    private $folder;

    /**
     * @var Mover
     */
    private $mover;

    /**
     * @var Imagy
     */
    private $imagy;

    public function __construct(
    FileRepository $file,
    FolderRepository $folder,
    Mover $mover,
    Imagy $imagy
  ) {
        $this->file = $file;
        $this->folder = $folder;
        $this->mover = $mover;
        $this->imagy = $imagy;
    }

    /**
     * CREATE A ITEM
     *
     * @return mixed
     */
    public function move(Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get data
            $data = $request->input('attributes');

            $destination = $this->folder->findFolderOrRoot($data['destination_folder']);

            $failedMoves = 0;
            foreach ($data['files'] as $file) {
                $failedMoves = $this->mover->move($this->file->find($file['id']), $destination);
            }

            if ($failedMoves > 0) {
                $message = trans('media::media.some files not moved');
                throw new Exception($message, 500);
            }

            $message = trans('media::media.files moved successfully');

            //Response
            $response = ['data' => $message];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }
        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * CREATE A ITEM
     *
     * @return mixed
     */
    public function destroy(Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get data
            $data = $request->input('attributes');

            foreach ($data['files'] as $file) {
                if ($file['is_folder'] === true) {
                    $this->deleteFolder($file['id']);

                    continue;
                }
                $this->deleteFile($file['id']);
            }

            //Response
            $response = ['data' => trans('media::messages.selected items deleted')];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }
        //Return response
        return response()->json($response, $status ?? 200);
    }

    private function deleteFile($fileId)
    {
        $file = $this->file->find($fileId);

        if ($file === null) {
            return;
        }

        $this->imagy->deleteAllFor($file);
        $this->file->destroy($file);
    }

    private function deleteFolder($folderId)
    {
        $folder = $this->folder->findFolder($folderId);

        if ($folder === null) {
            return;
        }

        $this->folder->destroy($folder);
    }
}
