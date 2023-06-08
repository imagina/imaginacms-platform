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
     * @param  UploadedFile  $file
     * @param  int  $parentId
     * @param  string  $disk
     * @return mixed
     */
    public function createFromFile(UploadedFile $file, $parentId = 0, $disk = null);

    /**
     * Find a file for the entity by zone
     * @param string $zone
     * @param object $entity
     * @return object
     */
    public function findFileByZoneForEntity($zone, $entity);

    /**
     * Find multiple files for the given zone and entity
     * @param string $zone
     * @param object $entity
     * @return object
     */
    public function findMultipleFilesByZoneForEntity($zone, $entity);

    /**
     * @param Request $request
     * @return mixed
     */
    public function serverPaginationFilteringFor(Request $request);

    /**
     * @param int $folderId
     * @return Collection
     */
    public function allChildrenOf($folderId) : Collection;

    public function findForVirtualPath($criteria);

    public function allForGrid() : Collection;

    public function move(File $file, File $destination) : File;
  
  
  /**
   * new inteface IMAGINA API
   */
  public function getItemsBy($params);
  
  public function getItem($criteria, $params = false);
  
  public function create($data);
  
  public function updateBy($criteria, $data, $params = false);
  
  public function deleteBy($criteria, $params = false);
  
}
