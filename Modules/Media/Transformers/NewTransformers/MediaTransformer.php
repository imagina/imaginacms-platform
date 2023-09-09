<?php

namespace Modules\Media\Transformers\NewTransformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Media\Helpers\FileHelper;
use Modules\Media\Image\Imagy;
use Modules\Media\Image\ThumbnailManager;
use Modules\Iprofile\Transformers\UserTransformer;

class MediaTransformer extends JsonResource
{
    /**
     * @var Imagy
     */
    private $imagy;

    /**
     * @var ThumbnailManager
     */
    private $thumbnailManager;
  private $defaultUrl;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->imagy = app(Imagy::class);
        $this->thumbnailManager = app(ThumbnailManager::class);
    $this->instancesDefaultUrl();
    }

    public function toArray($request)
    {
    $filePath = $this->getPath();

        $data = [
            'id' => $this->id,
            'filename' => $this->filename,
      'mimeType' => $this->mimetype,
      'fileSize' => $this->filesize,
      'path' => $filePath,
      'relativePath' => $this->path->getRelativeUrl(),
            'isImage' => $this->isImage(),
      'isVideo' => $this->isVideo(),
            'isFolder' => $this->isFolder(),
            'mediaType' => $this->media_type,
            'folderId' => $this->folder_id,
      'description' => $this->description,
      'alt' => $this->alt_attribute,
      'keywords' => $this->keywords,
      'createdBy' => $this->created_by,
      'createdAt' => $this->created_at,
      'updatedAt' => $this->updated_at,
      'faIcon' => FileHelper::getFaIcon($this->media_type),
            'disk' => $this->disk,
            'extension' => $this->extension,
            'zone' => $this->when(isset($this->pivot->zone) && ! empty($this->pivot->zone), $this->pivot->zone ?? null),
            'url' => $this->url ?? '#',
      'createdByUser' => new UserTransformer($this->createdBy),
      'tags' => $this->tags->pluck('name')->toArray(),
        ];

    //Thumbnails
        foreach ($this->thumbnailManager->all() as $thumbnail) {
            $thumbnailName = $thumbnail->name();
      $thumbnailPath = $this->isImage() ? $this->getValidatedThumbnail($thumbnailName) : $this->defaultUrl;
      //Include the thumbnails data as relation
      $data['thumbnails'][] = ['name' => $thumbnailName, 'path' => $thumbnailPath, 'size' => $thumbnail->size(),];
      //Include thumnail in main three
      $data[$thumbnailName] = $thumbnailPath;
      //Include the relative thumnail in main three
      $data['relative' . ucfirst($thumbnailName)] = str_replace(url("/"), "", $thumbnailPath);
        }

        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
                $data[$lang]['description'] = $this->hasTranslation($lang) ?
                  $this->translate("$lang")['description'] : '';
                $data[$lang]['altAttribute'] = $this->hasTranslation($lang) ?
                  $this->translate("$lang")['alt_attribute'] ?? '' : '';
                $data[$lang]['keywords'] = $this->hasTranslation($lang) ?
                  $this->translate("$lang")['keywords'] : '';
            }
        }

        return $data;
    }

  private function instancesDefaultUrl()
  {
    //Get entity attributes
    $entityNamespace = get_class($this->resource);
    $entityNamespaceExploded = explode('\\', strtolower($entityNamespace));
    $moduleName = $entityNamespaceExploded[1];//Get module name
    $entityName = $entityNamespaceExploded[3];//Get entity name
    //Define default image
    $this->defaultUrl = strtolower(url("modules/{$moduleName}/img/{$entityName}/default.jpg"));
  }

    private function getPath()
    {
        if ($this->is_folder) {
            return (string) $this->pathString;
        }

    return (string)$this->path . "?u=" . ($this->updated_at->timestamp ?? "");
    }

    private function getDeleteUrl()
    {
        if ($this->isImage()) {
            return route('api.media.media.destroy', $this->id);
        }

        return route('api.media.folders.destroy', $this->id);
    }

  private function getValidatedThumbnail($thumbnailName)
  {
    //Validate the attribute has_thumbnail
    if (!$this->has_thumbnails) return $this->getPath();
    //Validate if not is in disk
    if (isset($this->disk) && !in_array($this->disk, array_keys(config("filesystems.disks"))))
      return app("Modules\Media\Services\\" . ucfirst($this->disk) . "Service")->getThumbnail($this->resource, $name);
    //Default thumbnails
    return $this->imagy->getThumbnail($this->resource, $thumbnailName);
  }
}
