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

  public function __construct($resource)
  {
    parent::__construct($resource);

    $this->imagy = app(Imagy::class);
    $this->thumbnailManager = app(ThumbnailManager::class);
  }

  public function toArray($request)
  {

    $data = [
      'id' => $this->id,
      'filename' => $this->filename,
      'path' => $this->getPath(),
      'isImage' => $this->isImage(),
      'isFolder' => $this->isFolder(),
      'mediaType' => $this->media_type,
      'faIcon' => FileHelper::getFaIcon($this->media_type),
      'createdAt' => $this->created_at,
      'folderId' => $this->folder_id,
      'filesize' => $this->filesize,
      'disk' => $this->disk,
      'extension' => $this->extension,
      'zone' => $this->when(isset($this->pivot->zone) && !empty($this->pivot->zone), $this->pivot->zone ?? null),
      'smallThumb' => $this->imagy->getThumbnail($this->resource, 'smallThumb'),
      'mediumThumb' => $this->imagy->getThumbnail($this->resource, 'mediumThumb'),
      'largeThumb' => $this->imagy->getThumbnail($this->resource, 'largeThumb'),
      'extraLargeThumb' => $this->imagy->getThumbnail($this->resource, 'extraLargeThumb'),
      'createdBy' => $this->created_by,
      'url' => $this->url ?? '#',

    ];

    $data['createdByUser'] = new UserTransformer($this->createdBy);

    foreach ($this->thumbnailManager->all() as $thumbnail) {
      $thumbnailName = $thumbnail->name();

      $data['thumbnails'][] = [
        'name' => $thumbnailName,
        'path' => $this->imagy->getThumbnail($this->resource, $thumbnailName),
        'size' => $thumbnail->size(),
      ];
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
    

    foreach ($this->tags as $tag) {
      $data['tags'][] = $tag->name;
    }

    return $data;
  }

  private function getPath()
  {
    if ($this->is_folder) {
      return (string)$this->pathString;
    }

    return (string)$this->path;
  }

  private function getDeleteUrl()
  {
    if ($this->isImage()) {
      return route('api.media.media.destroy', $this->id);
    }

    return route('api.media.folders.destroy', $this->id);
  }
}
