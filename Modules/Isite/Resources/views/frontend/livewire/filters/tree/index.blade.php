<?php
function includeWithVariables($item, $breadcrumb, $level, $name, $itemSelected)
{

$output = NULL;

// Extract the variables to a local namespace


// Start output buffering
ob_start();

$isSelected = !empty($itemSelected) ? $itemSelected->id == $item->id ? true : false : false;
?>


<li class="list-group-item <?=$isSelected ? 'item-selected' : ''?> level-<?=$level?>">
  
  <?php
  $children = $item->children;
  
  $expanded = false;

  
  foreach ($breadcrumb as $itemBreadcrumb) {
    if ($itemBreadcrumb->id == $item->id)
      $expanded = true;
  }
  $mediaFiles = $item->mediaFiles();
  isset($mediaFiles->iconimage->path) && !strpos($mediaFiles->iconimage->path, "default.jpg") ? $withIcon = true : $withIcon = false;
  if($children->isNotEmpty()){
  ?>
  <div class="link-desktop d-none d-md-block <?=$isSelected && $children ? 'font-weight-bold' : ''?>">
    <a href="<?=$item->url?>" style="cursor: pointer"
       onclick="event.preventDefault(); emit_<?=$name?>(<?=$item->id?>,'<?=$item->url?>')"
       class="<?=$name?>-link text-href ">
      <?php
      if($withIcon){
      ?>
      <img class="item-icon filter" src="<?=$mediaFiles->iconimage->path?>">
      <?php
      }
      ?>
      
      <span class="<?=$withIcon ? 'span-with-icon' : 'span-without-icon'?>"
            title="<?=$item->title?>"><?=$item->title?></span>
    </a>
    <a class="icon-collapsable" data-toggle="collapse" role="button"
       href="#multiCollapse-<?=$item->id?>" aria-expanded="<?=$expanded ? 'true' : 'false'?>"
       aria-controls="multiCollapse-<?=$item->id?>">
      <i class="fa angle"></i>
    </a>
  </div>
  <div class="link-movil d-block d-md-none <?=$isSelected && $children ? 'font-weight-bold' : ''?>">
    <a class="text-collapsable" data-toggle="collapse" role="button"
       href="#multiCollapse-<?=$item->id?>" aria-expanded="<?=$isSelected && $children ? 'true' : 'false'?>"
       aria-controls="multiCollapse-<?=$item->id?>">
      
      <?php
      if($withIcon){
      ?>
      <img class="item-icon filter" src="<?=$mediaFiles->iconimage->path?>">
      <?php
      }
      ?>
      <span class="<?=$withIcon ? 'span-with-icon' : 'span-without-icon'?>"
            title="<?=$item->title?>"><?=$item->title?></span>
    </a>
    <a href="<?=$item->url?>" style="cursor: pointer"
       onclick="event.preventDefault(); emit_<?=$name?>(<?=$item->id?>,'<?=$item->url?>')"
       class="<?=$name?>-link icon-href float-right">
      <i class="fa fa-external-link"></i>
    </a>
  </div>
  <div class="collapse multi-collapse mt-2 <?=$expanded ? 'show' : ''?>" id="multiCollapse-<?=$item->id?>">
    <ul class="list-group list-group-flush">
      <?php
      foreach ($children as $subItem) {
        includeWithVariables($subItem, $breadcrumb, $level + 1, $name, $itemSelected);
      }
      ?>
    </ul>
  </div>
  <?php
  }else{
  ?>
  <a href="<?=$item->url?>" style="cursor: pointer"
     onclick="event.preventDefault(); emit_<?=$name?>(<?=$item->id?>,'<?=$item->url?>')"
     class="<?=$name?>-link link-childless d-block <?=$isSelected && $children->isEmpty() ? 'font-weight-bold' : ''?>">
    
    <?php
    if(isset($mediaFiles->iconimage->path) && !strpos($mediaFiles->iconimage->path, "default.jpg")){
    ?>
    <img class="item-icon filter" src="<?=$mediaFiles->iconimage->path?>">
    <?php
    }
    ?>
    <span title="<?=$item->title?>"><?=$item->title?></span>
  </a>
  <?php
  }
  ?>

</li>

<?php

// End buffering and return its contents
$output = ob_get_clean();


print $output;


}
?>

<div class="filter-tree filter-<?=$name?> filter-tree-style-<?=$layout?> mb-4">
  @if($this->items && count($this->items)>0)
    
    <div class="title">
      <a class="item" data-toggle="collapse" href="#collapseCategories" role="button"
         aria-expanded="<?=$isExpanded ? 'true' : 'false'?>" aria-controls="collapseCategories"
         class="<?=$isExpanded ? '' : 'collapsed'?>">
        
        <h5 class="p-3 border-top border-bottom">
          <?= trans($title) ?>
          <i class="fa fa angle float-right" aria-hidden="true"></i>
        </h5>
      
      </a>
    </div>
    
    <div class="collapse <?=$isExpanded ? 'show' : ''?>" id="collapseCategories">
      <div class="row">
        <div class="col-12">
          <div class="list-categories">
            <ul class="list-group list-group-flush">
              <?php
              foreach ($this->items as $item) {
                includeWithVariables($item, $this->breadcrumb, 0, $name, $itemSelected);
              }
              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  
  @endif
</div>

@section("scripts")
  @parent
  <script>
    
    function emit_{{$name}}(itemId, itemUrl) {
      var configEmit =  {!! $emitTo ? 'true' : 'false' !!};
      if (configEmit) {
        window.livewire.emit('updateItemSelected', itemId)
      } else {
        window.location.href = itemUrl
      }
    }
  
  
  </script>
@endsection