<?php

namespace Modules\Media\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Modules\Core\Repositories\BaseRepository;
use Modules\Media\Entities\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileRepository extends BaseRepository
{
    /**
     * Create a file row from the given file
     *
     * @param  int  $parentId
     * @param  string  $disk
     * @return mixed
     */
    public function createFromFile(UploadedFile $file, int $parentId = 0, string $disk = null);

    /**
     * Find a file for the entity by zone
     *
     * @param  string  $zone
     * @param  object  $entity
     * @return object
     */
    public function findFileByZoneForEntity($zone, object $entity): object;

    /**
     * Find multiple files for the given zone and entity
     *
     * @param  string  $zone
     * @param  object  $entity
     * @return object
     */
    public function findMultipleFilesByZoneForEntity(string $zone, object $entity): object;

    /**
     * @return mixed
     */
    public function serverPaginationFilteringFor(Request $request);

    /**
     * @param  int  $folderId
     */
    public function allChildrenOf(int $folderId): Collection;

    public function findForVirtualPath($criteria);

    public function allForGrid(): Collection;

    public function move(File $file, File $destination): File;

    /**
     * new inteface IMAGINA API
     */
    public function getItemsBy($params);

    public function getItem($criteria, $params = false);

    public function create($data);

    public function updateBy($criteria, $data, $params = false);

    public function deleteBy($criteria, $params = false);
}
