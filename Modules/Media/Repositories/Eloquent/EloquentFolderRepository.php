<?php

namespace Modules\Media\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Media\Entities\File;
use Modules\Media\Events\FolderIsCreating;
use Modules\Media\Events\FolderIsDeleting;
use Modules\Media\Events\FolderIsUpdating;
use Modules\Media\Events\FolderStartedMoving;
use Modules\Media\Events\FolderWasCreated;
use Modules\Media\Events\FolderWasUpdated;
use Modules\Media\Repositories\FolderRepository;
use Modules\Media\Support\Collection\NestedFoldersCollection;

class EloquentFolderRepository extends EloquentBaseRepository implements FolderRepository
{
    public function all()
    {
        return $this->model->with('translations')->where('is_folder', 1)->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Find a folder by its ID
     * @param int $folderId
     * @return File|null
     */
    public function findFolder($folderId)
    {
        return $this->model->where('is_folder', 1)->where('id', $folderId)->first();
    }

    public function create($data)
    {
      $disk = Arr::get($data,'disk');
      $settingDisk = setting('media::filesystem', null, config("asgard.media.config.filesystem"));
      if($disk == "publicmedia" && $settingDisk == "s3") $disk = $settingDisk;

        $data = [
            'filename' => Arr::get($data, 'name') ?? Arr::get($data, 'filename'),
            'path' => $this->getPath($data),
            'is_folder' => true,
            'folder_id' => Arr::get($data, 'parent_id') ?? 0,
            'disk' => $disk
        ];
        event($event = new FolderIsCreating($data));
        $folder = $this->model->create($event->getAttributes());

        event(new FolderWasCreated($folder, $data));

        return $folder;
    }

    public function update($model, $data)
    {
        $previousData = [
            'filename' => $model->filename,
            'path' => $model->path,
            'id' => $model->id,
        ];
        $formattedData = [
            'id' => Arr::get($data, 'id'),
            'filename' => Arr::get($data, 'name') ?? Arr::get($data, 'filename'),
            'path' => $this->getPath($data),
            'parent_id' => Arr::get($data, 'parent_id'),
            'disk' => Arr::get($data,'disk')
        ];

        event($event = new FolderIsUpdating($formattedData));
      
      $model->update($event->getAttributes());
   
      event(new FolderWasUpdated($model, $formattedData, $previousData));
 
      return $model;
    }

    public function destroy($folder)
    {
        event(new FolderIsDeleting($folder));
        $folder->delete();
        return $folder->forceDelete();
    }

    /**
     * @param File $folder
     * @return Collection
     */
    public function allChildrenOf(File $folder)
    {
        $path = $folder->path->getRelativeUrl();

        return $this->model->where('path', 'like', "{$path}/%")->get();
    }

    public function allNested(): NestedFoldersCollection
    {
        return new NestedFoldersCollection($this->all());
    }

    public function move(File $folder, File $destination): File
    {
        $previousData = [
            'filename' => $folder->filename,
            'path' => $folder->path,
        ];

        $folder->update([
            'path' => $this->getNewPathFor($folder->filename, $destination),
            'folder_id' => $destination->id,
        ]);

        event(new FolderStartedMoving($folder, $previousData));

        return $folder;
    }

    /**
     * Find the folder by ID or return a root folder
     * which is an instantiated File class
     * @param int $folderId
     * @return File
     */
    public function findFolderOrRoot($folderId): File
    {
        $destination = $this->findFolder($folderId);

        if ($destination === null) {
            $destination = $this->makeRootFolder();
        }

        return $destination;
    }

    private function getNewPathFor(string $filename, File $folder)
    {
        return $this->removeDoubleSlashes($folder->path->getRelativeUrl() . '/' . Str::slug($filename));
    }

    private function removeDoubleSlashes(string $string) : string
    {
        return str_replace('//', '/', $string);
    }

    /**
     * @param array $data
     * @return string
     */
    private function getPath(array $data): string
    {
        if (array_key_exists('parent_id', $data)) {
            $parent = $this->findFolder($data['parent_id']);
            if ($parent !== null) {
                return $parent->path->getRelativeUrl() . '/' . Str::slug(Arr::get($data, 'name'));
            }
        }

        return config('asgard.media.config.files-path') . Str::slug(Arr::get($data, 'name'));
    }

    /**
     * Create an instantiated File entity, appointed as root
     * @return File
     */
    private function makeRootFolder() : File
    {
        return new File([
            'id' => 0,
            'folder_id' => 0,
            'path' => config('asgard.media.config.files-path'),
        ]);
    }

  /**
   * @param bool $params
   * @return mixed
   */
  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include ?? [])) {//If Request all relationships
      $query->with(["createdBy"]);
    } else {//Especific relationships
      $includeDefault = [];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTERS ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;//Short filter

      //Filter by date
      if (isset($filter->date)) {
        $date = $filter->date;//Short filter date
        $date->field = $date->field ?? 'created_at';
        if (isset($date->from))//From a date
          $query->whereDate($date->field, '>=', $date->from);
        if (isset($date->to))//to a date
          $query->whereDate($date->field, '<=', $date->to);
      }

      //Order by
      if (isset($filter->order)) {
        $orderByField = $filter->order->field ?? 'is_Folder';//Default field
        $orderWay = $filter->order->way ?? 'desc';//Default way
        $query->orderBy($orderByField, $orderWay);//Add order to query
      }else{
        $query->orderBy('is_Folder', 'desc');//Add order to query
        $query->orderBy('media__files.created_at', 'desc');//Add order to query
      }

      //folder id
      if (isset($filter->folderId) && (string)$filter->folderId != "") {
        $query->where('folder_id', $filter->folderId);

      }

      if (!isset($params->permissions['media.medias.index']) ||
        (isset($params->permissions['media.medias.index']) &&
          !$params->permissions['media.medias.index'])) {
        $query->where("is_folder","!=",0);
      }


      if (!isset($params->permissions['media.folders.index']) ||
        (isset($params->permissions['media.folders.index']) &&
          !$params->permissions['media.folders.index'])) {
        $query->where("is_folder","!=",1);
      }

      //folder name
      if (isset($filter->folderName) && $filter->folderName != "Home") {

        $folder = \DB::table("media__files as files")
          ->where("is_folder",true)
          ->where("filename",$filter->folderName)
          ->first();

        if(isset($folder->id)){
          $query->where('folder_id',$filter->folderId ?? $folder->id);
        }
      }

      //is Folder
      $query->where('is_folder',true);

      //is Folder
      if (isset($filter->zone)) {
        $filesIds = \DB::table("media__imageables as imageable")
          ->where('imageable.zone',$filter->zone)
          ->where('imageable.imageable_id',$filter->entityId)
          ->where('imageable.imageable_type',$filter->entity)
          ->get()->pluck("file_id")->toArray();
        $query->whereIn("id",$filesIds);
      }
  
      //disk
      if (isset($filter->disk) && !empty($filter->disk)) {
        $query->whereIn("disk",$filter->disk);
      }

      //add filter by search
      if (isset($filter->search) && $filter->search) {
        //find search in columns
        $query->where(function ($query) use ($filter) {
          $query->where('id', 'like', '%' . $filter->search . '%')
            ->orWhere('filename', 'like', '%' . $filter->search . '%')
            ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
            ->orWhere('created_at', 'like', '%' . $filter->search . '%');
        });
      }
    }

    $this->validateIndexAllPermission($query,$params);
    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);

    //dd($query->toSql(), $query->getBindings());
    /*== REQUEST ==*/
    if (isset($params->page) && $params->page) {
      return $query->paginate($params->take);
    } else {
      $params->take ? $query->take($params->take) : false;//Take
      return $query->get();
    }
  }

  public function getItem($criteria, $params = false)
      {
        //Initialize query
        $query = $this->model->query();
  
      /*== RELATIONSHIPS ==*/
      if(in_array('*',$params->include ?? [])){//If Request all relationships
        $query->with([]);
      }else{//Especific relationships
        $includeDefault = [];//Default relationships
        if (isset($params->include))//merge relations with default relationships
          $includeDefault = array_merge($includeDefault, $params->include);
        $query->with($includeDefault);//Add Relationships to query
      }
  
        /*== FILTER ==*/
        if (isset($params->filter)) {
          $filter = $params->filter;
  
          if (isset($filter->field))//Filter by specific field
            $field = $filter->field;
        }
  
        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
          $query->select($params->fields);
  
        /*== REQUEST ==*/
        return $query->where($field ?? 'id', $criteria)->first();
      }

  function validateIndexAllPermission(&$query, $params)
  {
    // filter by permission: index all leads

    if (!isset($params->permissions['media.folders.index-all']) ||
      (isset($params->permissions['media.folders.index-all']) &&
        !$params->permissions['media.folders.index-all'])) {
      $user = $params->user;
      $role = $params->role;
      // if is salesman or salesman manager or salesman sub manager
      $query->where('created_by', $user->id);


    }
  }

}
