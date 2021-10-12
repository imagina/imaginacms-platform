<?php

namespace Modules\Media\Support\Traits;

use Modules\Media\Entities\File;
use Modules\Media\Image\Imagy;
use Modules\Media\Image\ThumbnailManager;

trait MediaRelation
{
    /**
     * Make the Many To Many Morph To Relation
     * @return object
     */
    public function files()
    {
        return $this->morphToMany(File::class, 'imageable', 'media__imageables')->withPivot('zone', 'id')->withTimestamps()->orderBy('order');
    }

    /**
     * Make the Many to Many Morph to Relation with specific zone
     * @param string $zone
     * @return object
     */
    public function filesByZone($zone)
    {
        return $this->morphToMany(File::class, 'imageable', 'media__imageables')
            ->withPivot('zone', 'id')
            ->wherePivot('zone', '=', $zone)
            ->withTimestamps()
            ->orderBy('order');
    }

    /**
     * Order and transform all files data
     *
     * @return array
     */
    public function mediaFiles()
    {
        $imagy = app(Imagy::class);
        $files = $this->files;//Get files

        //Get entity attributes
        $entityNamespace = get_class($this);
        $entityNamespaceExploded = explode('\\', strtolower($entityNamespace));
        $moduleName = $entityNamespaceExploded[1];//Get module name
        $entityName = $entityNamespaceExploded[3];//Get entity name
        //Get media fillable
        $mediaFillable = config("asgard.{$moduleName}.config.mediaFillable.{$entityName}") ?? [];
        //Define default image
        $defaultPath = strtolower(url("modules/{$moduleName}/img/{$entityName}/default.jpg"));
        $response = [];//Default response

        //Transform Files
        foreach ($mediaFillable as $fieldName => $fileType) {
            $zone = strtolower($fieldName);//Get zone name
            $response[$zone] = ($fileType == 'multiple') ? [] : false;//Default zone response
            //Get files by zone
            $filesByZone = $files->filter(function ($item) use ($zone) {
                return ($item->pivot->zone == strtolower($zone));
            });
            //Add fake file
            if (!$filesByZone->count()) $filesByZone = [0];

            //Transform files
            foreach ($filesByZone as $file) {
                $fileTransformer = (object)[
                    'id' => $file->id ?? null,
                    'filename' => $file->filename ?? null,
                    'mimeType' => $file->mimetype ?? null,
                    'fileSize' => $file->filesize ?? null,
                    'path' => $file ? ($file->is_folder ? $file->path->getRelativeUrl() : (string)$file->path) : $defaultPath,
                    'relativePath' => $file ? $file->path->getRelativeUrl() : '',
                    'isImage' => $file ? $file->isImage() : false,
                    'isVideo' => $file ? $file->isVideo() : false,
                    'isFolder' => $file ? $file->isFolder() : false,
                    'mediaType' => $file->media_type ?? null,
                    'createdAt' => $file->created_at ?? null,
                    'folderId' => $file->folder_id ?? null,
                    'createdBy' => $file->created_by ?? null
                ];
                //Add imagy
  
              $thumbnails = app(ThumbnailManager::class)->all();
              foreach ($thumbnails as $thumbnail){
                $name = $thumbnail->name();
                $fileTransformer->{$name} = $file && $file->isImage() ? $imagy->getThumbnail($file, $name) : $defaultPath;
                $fileTransformer->{'relative'.ucfirst($name)} = $file  && $file->isImage() ? str_replace(url("/"),"",$imagy->getThumbnail($file, $name)) : $defaultPath;
              }
             
                //Add to response
                if ($fileType == 'multiple') {
                    if ($file) array_push($response[$zone], $fileTransformer);
                } else $response[$zone] = $fileTransformer;
            }
        }

        //Response
        return (object)$response;
    }
}
