<?php

namespace Modules\Media\Support\Traits;

use Modules\Media\Entities\File;
use Modules\Media\Image\Imagy;
use Modules\Media\Image\ThumbnailManager;
use Modules\Media\Transformers\NewTransformers\MediaTransformer;

trait MediaRelation
{
    /**
     * Make the Many To Many Morph To Relation
     */
    public function files()
    {
        $tenantWithCentralData = config('asgard.media.config.tenantWithCentralData.imageable');

        if ($tenantWithCentralData) {
            return $this->morphToMany(File::class, 'imageable', 'media__imageables')->with('translations')->withPivot('zone', 'id')->withTimestamps()->orderBy('order')->withoutTenancy();
        } else {
            return $this->morphToMany(File::class, 'imageable', 'media__imageables')->with('translations')->withPivot('zone', 'id')->withTimestamps()->orderBy('order');
        }
    }

    /**
     * Make the Many to Many Morph to Relation with specific zone
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
     */
    public function mediaFiles()
    {
        $files = $this->files; //Get files

        //Get entity attributes
        $entityNamespace = get_class($this);
        $entityNamespaceExploded = explode('\\', strtolower($entityNamespace));
        $moduleName = $entityNamespaceExploded[1]; //Get module name
        $entityName = $entityNamespaceExploded[3]; //Get entity name
    //Get media fillable
        $mediaFillable = config("asgard.{$moduleName}.config.mediaFillable.{$entityName}") ?? [];
        //Define default image
        $defaultPath = strtolower(url("modules/{$moduleName}/img/{$entityName}/default.jpg"));
        $response = []; //Default response

        //Transform Files
        foreach ($mediaFillable as $fieldName => $fileType) {
            $zone = strtolower($fieldName); //Get zone name
            $response[$zone] = ($fileType == 'multiple') ? [] : false; //Default zone response
      //Get files by zone
            $filesByZone = $files->filter(function ($item) use ($zone) {
                return $item->pivot->zone == strtolower($zone);
            });
            //Add fake file
            if (! $filesByZone->count()) {
                $filesByZone = [0];
            }

            //Transform files
            foreach ($filesByZone as $file) {
                $transformedFile = $this->transformFile($file, $defaultPath);
                //Add to response
                if ($fileType == 'multiple') {
                    if ($file) {
                        array_push($response[$zone], $transformedFile);
                    }
                } else {
                    $response[$zone] = $transformedFile;
                }
            }
        }

        //Response
        return (object) $response;
    }

  public function transformFile($file, $defaultPath)
    {
    //Create a mokup of a file if not exist
    if (!$file) $file = new File(['path' => $defaultPath, 'is_folder' => 0]);
    //Transform the file
    return json_decode(json_encode(new MediaTransformer($file)));
    }
}
