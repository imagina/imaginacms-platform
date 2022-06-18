@if(isset($itemListLayout) && $itemListLayout=='carousel')
<div id="idCarousel_{{$this->id}}" class="owl-carousel">
@endif

@foreach($items as $key => $item)
  <div class="{{$layoutClass[$key%count($layoutClass)]}} {{$itemMainClass}}" onclick="checkModal_{{$itemModal['idModal']}}({{$item->id}})" >

    <?php
    $hash = sha1($itemComponentNamespace);
    if (isset($component)) {
      $__componentOriginal{$hash} = $component;
    }
    $component = $__env->getContainer()->make($itemComponentNamespace, array_merge($itemComponentAttributes, ["item" => $item,"itemListLayout"=>$itemListLayout,"editLink"=>$editLink,"tooltipEditLink"=>$tooltipEditLink]));
    $component->withName($itemComponentName);
    if ($component->shouldRender()):
      $__env->startComponent($component->resolveView(), $component->data());
      if (isset($__componentOriginal{$hash})):
        $component = $__componentOriginal{$hash};
        unset($__componentOriginal{$hash});
      endif;
      echo $__env->renderComponent();
    endif;
    ?>
  
  </div>
@endforeach

@if(isset($itemListLayout) && $itemListLayout=='carousel')
</div>
@endif