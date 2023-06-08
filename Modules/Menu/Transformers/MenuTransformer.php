<?php

namespace Modules\Menu\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Ihelpers\Transformers\BaseApiTransformer;
use Illuminate\Support\Facades\Cache;
use Modules\Menu\Transformers\MenuitemTransformer;
use Modules\Isite\Transformers\RevisionTransformer;

class MenuTransformer extends BaseApiTransformer
{
  public function toArray($request)
  {
    
    $data = [
      'id' => $this->when($this->id, $this->id),
      'name' => $this->when($this->name, $this->name),
      'title' => $this->when($this->title, $this->title),
      'primary' => $this->when($this->primary, $this->primary),
      'isDefault' => $this->when(isset($this->is_default), $this->is_default),
      'status' => $this->when(isset($this->status), $this->status),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      //'menuitems' => MenuitemTransformer::collection($this->whenLoaded('menuitems'))
      'menuitems' => $this->getMenuItems(),
      'revisions' => RevisionTransformer::collection($this->whenLoaded('revisions')),
    ];

    $filter = json_decode($request->filter);
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
      foreach ($languages as $lang => $value) {
        $data[$lang]['title'] = $this->hasTranslation($lang) ? $this->translate("$lang")['title'] : '';
        $data[$lang]['status'] = $this->hasTranslation($lang) ? $this->translate("$lang")['status'] : '';
      }
    }
  
  
    return $data;
  }

  /*
  * Integration with tenant - menuitems
  */
  public function getMenuItems(){
  
  
    return Cache::store(config("cache.default"))->remember('menu_items_' . $this->id.(tenant()->id ?? ""), 60, function () {
  
      $params = [
        "include" => [],
        "filter" => [
          "menu" => $this->id,
          "order" => ['way' => 'asc']
        ],
      ];
  
      $menuItems = app('Modules\Menu\Repositories\MenuItemRepository')->getItemsBy(json_decode(json_encode($params)));
     
      if (!empty($menuItems))
        return MenuitemTransformer::collection($menuItems);
  
      return '';
    });
  }


}
