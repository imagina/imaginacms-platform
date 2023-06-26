<?php

namespace Modules\Media\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Media\Repositories\FolderRepository;

class AllNestableFolderController extends Controller
{
    /**
     * @var FolderRepository
     */
    private $folder;

    public function __construct(FolderRepository $folder)
    {
        $this->folder = $folder;
    }

    public function __invoke(): JsonResponse
    {
        $array = [];
        $folders = $this->folder->allNested()->nest()->listsFlattened('filename', null, 0, $array, '--- ');

        return response()->json($folders);
    }
}
