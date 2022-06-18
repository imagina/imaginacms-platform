<!--
This Partials depends on the following variables:
 $itemComponentNamespace: is the namespace to the Blade component
 examples:
      "Modules\Icommerce\View\Components\ProductListItem"
      "Modules\Isite\View\Components\ItemList"
 
 $itemComponent: is the name registered in the ServiceProvider in ehach Module
 examples:
      "isite::item-list"
      "icommerce::product-list-item"
 
-->
<?php
$hash = sha1($itemComponentNamespace);
if (isset($component)) {
  $__componentOriginal{$hash} = $component;
}
$component = $__env->getContainer()->make($itemComponentNamespace, array_merge([
  "item" => $item ?? null,
  "positionNumber"=>$position ?? null,
  "layout"=>$itemLayout ?? null,
  "parentAttributes"=>$attributes ?? [],
  "editLink"=>$editLink ?? null,
  "tooltipEditLink"=>$tooltipEditLink ?? null
],$itemComponentAttributes ?? []));
$component->withName($itemComponent);
if ($component->shouldRender()):
  $__env->startComponent($component->resolveView(), $component->data());
  if (isset($__componentOriginal{$hash})):
    $component = $__componentOriginal{$hash};
    unset($__componentOriginal{$hash});
  endif;
  echo $__env->renderComponent();
endif;
?>