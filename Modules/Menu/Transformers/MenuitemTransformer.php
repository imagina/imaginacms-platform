<?php

namespace Modules\Menu\Transformers;
use Illuminate\Http\Resources\Json\Resource;
use Modules\Ihelpers\Transformers\BaseApiTransformer;

class MenuitemTransformer extends BaseApiTransformer
{
  public function toArray($request)
  {
    $data = [
      'id'  => $this->when($this->id, $this->id),
      'menuId' => $this->when($this->menu_id, $this->menu_id),
      'menu' => new MenuTransformer($this->whenLoaded('menu')),
      'menuName' => $this->when($this->menu_id, $this->menu->name),
      'pageId' => $this->when($this->page_id, $this->page_id),
      'parent' => new MenuitemTransformer ($this->whenLoaded('parent')),
      'parentId' => intval($this->parent_id),
      'pageName' => $this->page_name,
      'position' => $this->when($this->position, $this->position),
      'target' => $this->when($this->target, $this->target),
      'moduleName' => $this->when($this->module_name, $this->module_name),
      'title' => $this->when($this->title, $this->title),
      'uri' => $this->when($this->uri, $this->uri),
      'url' => $this->when($this->url, $this->url),
      'status' => $this->when($this->status, $this->status),
      'isRoot' => $this->when($this->is_root, $this->is_root),
      'icon' => $this->when($this->icon, $this->icon),
      'linkType' => $this->when($this->link_type, $this->link_type),
      'locale' => $this->when($this->locale, $this->locale),
      'class' => $this->when($this->class, $this->class),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
    ];

    $filter = json_decode($request->filter);
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
      foreach ($languages as $lang => $value) {
        $data[$lang]['title'] = $this->hasTranslation($lang) ? $this->translate("$lang")['title'] : '';
        $data[$lang]['description'] = $this->hasTranslation($lang) ? $this->translate("$lang")['description'] : '';
        $data[$lang]['status'] = $this->hasTranslation($lang) ? $this->translate("$lang")['status'] : '';
        $data[$lang]['uri'] = $this->hasTranslation($lang) ? $this->translate("$lang")['uri'] : '';
        $data[$lang]['url'] = $this->hasTranslation($lang) ? $this->translate("$lang")['url'] : '';
      }
    }

    return $data;
  }
}
