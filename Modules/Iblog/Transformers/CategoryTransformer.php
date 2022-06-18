<?php

namespace Modules\Iblog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\UserProfileTransformer;
use Modules\Media\Image\Imagy;

class CategoryTransformer extends JsonResource
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
  }
  
  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
      'title' => $this->when($this->title, $this->title),
      'slug' => $this->when($this->slug, $this->slug),
      'url' => $this->url ?? '#',
      'description' => $this->description ?? '',
      'metaTitle' => $this->when($this->meta_title, $this->meta_title),
      'metaDescription' => $this->when($this->meta_description, $this->meta_description),
      'metaKeywords' => $this->when($this->meta_keywords, $this->meta_keywords),
      'mainImage' => $this->main_image,
      //'small_thumb' => $this->imagy->getThumbnail($this->mainimage, 'smallThumb'),
      //'medium_thumb' => $this->imagy->getThumbnail($this->mainimage, 'mediumThumb'),
      'secondaryImage' => $this->when($this->secondary_image, $this->secondary_image),
      'showMenu' => $this->show_menu ? '1' : '0',
      'featured' => $this->featured ? '1' : '0',
      'sortOrder' => !$this->sort_order ? "0": (string)$this->sort_order,
      'status' => $this->when(isset($this->status), $this->status),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      'options' => $this->when($this->options, $this->options),
      'parent' => new CategoryTransformer($this->whenLoaded('parent')),
      'parentId' => $this->parent_id,
      'layoutId' => $this->layout_id,
      'internal' => $this->when($this->internal, $this->internal),
      'children' => CategoryTransformer::collection($this->whenLoaded('children')),
      'posts' => PostTransformer::collection($this->whenLoaded('posts')),
      'mediaFiles' => $this->mediaFiles()
    ];
    
    $filter = json_decode($request->filter);
    
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
      
      foreach ($languages as $lang => $value) {
        $data[$lang]['title'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['title'] : '';
        $data[$lang]['slug'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['slug'] : '';
        $data[$lang]['description'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['description'] ?? '' : '';
        $data[$lang]['metaTitle'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['meta_title'] : '';
        $data[$lang]['metaDescription'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['meta_description'] : '';
      }
    }
    
    return $data;
  }
}
