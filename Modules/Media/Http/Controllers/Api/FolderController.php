<?php

namespace Modules\Media\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Media\Entities\File;
use Modules\Media\Http\Requests\CreateFolderRequest;
use Modules\Media\Repositories\FolderRepository;

class FolderController extends Controller
{
    /**
     * @var FolderRepository
     */
    private $folder;

    public function __construct(FolderRepository $folder)
    {
        $this->folder = $folder;
    }

    public function store(CreateFolderRequest $request): JsonResponse
    {
        $folder = $this->folder->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('media::folders.folder was created'),
            'data' => $folder,
        ]);
    }

    public function update(File $folder, CreateFolderRequest $request): JsonResponse
    {
        $folder = $this->folder->update($folder, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('media::folders.folder was updated'),
            'data' => $folder,
        ]);
    }

    public function destroy(File $folder): JsonResponse
    {
        $this->folder->destroy($folder);

        return response()->json([
            'errors' => false,
            'message' => trans('media::messages.folder deleted'),
        ]);
    }
}
