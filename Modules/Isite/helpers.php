<?php

if (!function_exists('alternate')) {
  
  function alternate($model)
  {
    
    $alternate = [];
    $supportedLocales = config("laravellocalization.supportedLocales");
    
    if(count($supportedLocales) == 1) return $alternate;
    
    $translations = $model->getTranslationsArray() ?? [];
    
    foreach ($translations as $locale => $data) {
      if(isset($data['slug'])){
        $href = \URL::to('/'.$locale.'/'.$data['slug']);
        $alternate[$locale] = [
          "slug" => $data['slug'],
          "link" => "<link rel='alternate' hreflang='$locale' href='$href'>"
        ];
      }
      
    }
    
    return $alternate;
    
  }
}

if (!function_exists('getEditLink')) {
  
  function getEditLink($repository)
  {
  
    switch ($repository) {
      case 'Modules\Icommerce\Repositories\ProductRepository':
        $editLink = "/iadmin/#/ecommerce/products?edit=";
        $tooltipEditLink = trans("isite::common.editLink.tooltipProduct");
        break;
      case 'Modules\Icommerce\Repositories\CategoryRepository':
        $editLink = "/iadmin/#/ecommerce/product-categories?edit=";
        $tooltipEditLink = trans("isite::common.editLink.tooltipCategory");
        break;
      case 'Modules\Icommerce\Repositories\ManufacturerRepository':
        $editLink = "/iadmin/#/ecommerce/manufacturers?edit=";
        $tooltipEditLink = trans("isite::common.editLink.tooltipManufacturer");
        break;
      case 'Modules\Iblog\Repositories\PostRepository':
        $editLink = "/iadmin/#/blog/posts/index?edit=";
        $tooltipEditLink = trans("isite::common.editLink.tooltipPost");
        break;
      case 'Modules\Iblog\Repositories\CategoryRepository':
        $editLink = "/iadmin/#/blog/categories/index?edit=";
        $tooltipEditLink = trans("isite::common.editLink.tooltipCategory");
        break;
      case 'Modules\Slider\Repositories\SlideRepository':
        $editLink = "/iadmin/#/slider/show/";
        $tooltipEditLink = trans("isite::common.editLink.tooltipSlide");
        break;
      case 'Modules\Iplaces\Repositories\PlaceRepository':
        $editLink = "/iadmin/#/iplaces/places/index?edit=";
        $tooltipEditLink = trans("isite::common.editLink.tooltipPlace");
        break;
        default:
        $editLink = "/iadmin/#/";
        $tooltipEditLink = "";
        break;
    }
    
    return [ $editLink, $tooltipEditLink];
  }
}
