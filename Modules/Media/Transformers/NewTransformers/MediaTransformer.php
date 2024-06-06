<?php

namespace Modules\Media\Transformers\NewTransformers;

use Illuminate\Http\Resources\Json\Resource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Media\Helpers\FileHelper;
use Modules\Media\Image\Imagy;
use Modules\Media\Image\ThumbnailManager;
use Modules\Iprofile\Transformers\UserTransformer;

class MediaTransformer extends Resource
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
      'smallThumb' => $this->imagy->getThumbnail($this->path, 'smallThumb'),
      'mediumThumb' => $this->imagy->getThumbnail($this->path, 'mediumThumb'),
      'createdBy' => $this->created_by
      
    ];
  
    $data['createdByUser'] = new UserTransformer($this->createdBy);
    
    foreach ($this->thumbnailManager->all() as $thumbnail) {
      $thumbnailName = $thumbnail->name();
      
      $data['thumbnails'][] = [
        'name' => $thumbnailName,
        'path' => $this->imagy->getThumbnail($this->path, $thumbnailName),
        'size' => $thumbnail->size(),
      ];
    }
    
    foreach (LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
      $data[$locale] = [];
      foreach ($this->translatedAttributes as $translatedAttribute) {
        $data[$locale][$translatedAttribute] = $this->translateOrNew($locale)->$translatedAttribute;
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
      return $this->path->getRelativeUrl();
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
