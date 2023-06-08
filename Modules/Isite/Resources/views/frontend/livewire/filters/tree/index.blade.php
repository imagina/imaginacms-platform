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
    <a href="<?=$item->url?>"
       onclick="event.preventDefault(); emit_<?=$name?>(<?=$item->id?>,'<?=$item->url?>')"
       class="<?=$name?>-link text-href cursor-pointer" aria-label="<?=$item->title?>">
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
       aria-controls="multiCollapse-<?=$item->id?>" aria-label="collapse" >
      <i class="fa angle"></i>
    </a>
  </div>
  <div class="link-movil d-block d-md-none <?=$isSelected && $children ? 'font-weight-bold' : ''?>">
    <a class="text-collapsable" data-toggle="collapse" role="button"
       href="#multiCollapse-<?=$item->id?>" aria-expanded="<?=$isSelected && $children ? 'true' : 'false'?>"
       aria-controls="multiCollapse-<?=$item->id?>" aria-label="<?=$item->title?>">
      
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
    <a href="<?=$item->url?>" aria-label="external-link"
       onclick="event.preventDefault(); emit_<?=$name?>(<?=$item->id?>,'<?=$item->url?>')"
       class="<?=$name?>-link icon-href float-right cursor-pointer">
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
  <a href="<?=$item->url?>" aria-label="<?=$item->title?>"
     onclick="event.preventDefault(); emit_<?=$name?>(<?=$item->id?>,'<?=$item->url?>')"
     class="<?=$name?>-link link-childless cursor-pointer d-block <?=$isSelected && $children->isEmpty() ? 'font-weight-bold' : ''?>">
    
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
      <a class="item <?=$isExpanded ? '' : 'collapsed'?>" data-toggle="collapse" href="#collapseCategories" role="button"
         aria-expanded="<?=$isExpanded ? 'true' : 'false'?>" aria-controls="collapseCategories"
         aria-label="<?= trans($title) ?>">
        
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
  <style>
    .filter-tree [class*="level-"] {
      padding-right: 0;
    }
    .filter-tree .level-0 {
      padding: 0.5rem 1.25rem;
    }
    .filter-tree .list-group-item .icon-collapsable .angle:before {
      content: "\f105";
    }
    .filter-tree .list-group-item .icon-collapsable[aria-expanded="true"] .angle:before {
      content: "\f107";
    }
    .filter-tree .list-group-item .item-icon {
      display: inline-block;
    }
    .filter-tree .list-group-item .link-desktop {
      position: relative;
      height: 30px;
    }
    .filter-tree .list-group-item .link-desktop .text-href {
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      margin-right: 10px;
    }
    .filter-tree .list-group-item .link-desktop .icon-collapsable {
      display: flex;
      justify-content: flex-end;
      height: 100%;
      align-items: center;
    }
    .filter-tree .list-group-item .link-movil {
      position: relative;
    }
    .filter-tree .list-group-item .link-movil .text-collapsable {
      display: block;
    }
    .filter-tree .list-group-item .link-movil .icon-href {
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-50%);
    }
    .filter-tree-style-ttys .item, .filter-tree-style-ttys .item-icon {
      display: none !important;
    }
    .filter-tree-style-ttys .list-group-item {
      padding: 0 !important;
    }
    .filter-tree-style-ttys .list-group-item a {
      color: #333333;
    }
    .filter-tree-style-ttys .list-group-item a:hover {
      color: var(--primary) !important;
      font-weight: bold !important;
    }
    .filter-tree-style-ttys .list-group-item.level-0 {
      padding: 0;
      border: 0;
    }
    .filter-tree-style-ttys .list-group-item.level-0 > .link-desktop {
      padding-left: 38px;
    }
    .filter-tree-style-ttys .list-group-item.level-0 > .link-desktop .icon-collapsable {
      justify-content: flex-start;
      font-weight: bold;
      font-size: 20px;
    }
    .filter-tree-style-ttys .list-group-item.level-0 > .link-desktop .text-href {
      left: 35px !important;
    }
    .filter-tree-style-ttys .list-group-item.level-0 .link-movil .icon-href {
      right: 10px;
    }
    .filter-tree-style-ttys .list-group-item.level-0 .link-desktop, .filter-tree-style-ttys .list-group-item.level-0 .link-movil {
      font-size: 1rem;
      background-color: #f0f0f0;
      font-weight: 400;
      border-radius: 0 20px 0 0;
      margin-bottom: 1rem;
      padding: 1rem;
      border: 0;
      height: 56px;
    }
    .filter-tree-style-ttys .list-group-item.level-0 .link-desktop .text-href, .filter-tree-style-ttys .list-group-item.level-0 .link-movil .text-href {
      left: 15px;
    }
    .filter-tree-style-ttys .list-group-item.level-0 .link-childless {
      font-size: 1rem;
      background-color: #f0f0f0;
      font-weight: 400;
      border-radius: 0 20px 0 0;
      margin-bottom: 1rem;
      padding: 1rem;
      border: 0;
      height: 56px;
    }
    .filter-tree-style-ttys .list-group-item.level-0 .multi-collapse {
      margin-bottom: 0.5rem;
    }
    .filter-tree-style-ttys .list-group-item.level-1 {
      border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
    .filter-tree-style-ttys .list-group-item.level-1 .link-movil .text-collapsable {
      padding: 0.7rem 1rem;
      height: 45px;
    }
    .filter-tree-style-ttys .list-group-item.level-1 .link-movil .text-collapsable:before {
      color: var(--primary);
      content: "•";
    }
    .filter-tree-style-ttys .list-group-item.level-1 .link-desktop, .filter-tree-style-ttys .list-group-item.level-1 .link-movil {
      padding: 0;
      background-color: #fff;
      font-size: 16px;
      margin-bottom: 0;
      padding-right: 1rem;
      height: 45px;
    }
    .filter-tree-style-ttys .list-group-item.level-1 .link-desktop .text-href .angle:before, .filter-tree-style-ttys .list-group-item.level-1 .link-movil .text-href .angle:before {
      content: none;
    }
    .filter-tree-style-ttys .list-group-item.level-1 .link-desktop .text-href:before, .filter-tree-style-ttys .list-group-item.level-1 .link-movil .text-href:before {
      color: var(--primary);
      content: "•";
    }
    .filter-tree-style-ttys .list-group-item.level-1 .link-childless {
      background-color: #fff;
      font-size: 16px;
      margin-bottom: 0;
      padding: 0.5rem 1rem;
      height: 45px;
    }
    .filter-tree-style-ttys .list-group-item.level-1 .link-childless .angle:before {
      content: none;
    }
    .filter-tree-style-ttys .list-group-item.level-1 .link-childless:before {
      color: var(--primary);
      content: "•";
    }
    @media (max-width: 991px) {
      .filter-tree-style-ttys .list-group-item.level-1 .link-childless {
        padding-top: 0.7rem !important;
      }
    }
    .filter-tree-style-ttys .list-group-item.level-1:last-child {
      border-bottom: 0;
    }
    .filter-tree-style-ttys .list-group-item.level-2 {
      border-bottom: 0;
      padding-left: 15px !important;
    }
    .filter-tree-style-ttys .list-group-item.level-2 .link-childless:before {
      content: "-";
    }
    .filter-tree-style-alnat .item {
      display: none;
    }
    .filter-tree-style-alnat .list-group .list-group-item {
      background-color: transparent;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 {
      margin-bottom: 20px;
      padding: 0;
      border: 0;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-desktop {
      font-size: 22px;
      background-color: var(--secondary);
      border-radius: 100px;
      height: 66px;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-desktop .icon-collapsable {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      height: 66px;
      border-radius: 100px;
      padding-right: 15px;
      color: #fff;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-desktop .text-href {
      color: #fff;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-desktop .text-href img {
      background-color: var(--secondary);
      border: 3px solid var(--secondary);
      border-radius: 50%;
      width: 66px;
      height: 66px;
      object-fit: none;
      position: absolute;
      top: -33px;
      left: 0;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-desktop .text-href .span-with-icon {
      left: 75px;
      position: absolute;
      top: -13px;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-desktop .text-href .span-without-icon {
      left: 15px;
      position: absolute;
      top: -13px;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-movil {
      display: block;
      position: relative;
      font-size: 22px;
      background-color: var(--secondary);
      border-radius: 100px;
      border-bottom: 0;
      height: 66px;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-movil a {
      color: #fff;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-movil img {
      background-color: var(--secondary);
      border: 3px solid var(--secondary);
      border-radius: 50%;
      width: 66px;
      height: 66px;
      object-fit: none;
      position: absolute;
      top: 0;
      left: 0;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-movil .icon-collapsable {
      align-items: baseline;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-movil .text-collapsable {
      position: absolute;
      left: 0;
      top: 0;
      height: 66px;
      display: flex;
      align-items: center;
      padding-bottom: 5px;
      width: 100%;
      border-radius: 100px;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-movil .text-collapsable .span-with-icon {
      padding-left: 75px;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-movil .text-collapsable .span-without-icon {
      padding-left: 15px;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-movil .text-href {
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
      width: 225px;
      height: 66px;
      display: flex;
      align-items: center;
      padding-bottom: 5px;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-movil .text-href .span-with-icon {
      padding-left: 75px;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-movil .text-href .span-without-icon {
      padding-left: 15px;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-movil .icon-href {
      right: 15px;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0.item-selected > .link-desktop, .filter-tree-style-alnat .list-group > .list-group-item.level-0.item-selected > .link-childless {
      background-color: var(--primary);
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0.item-selected > .link-desktop img, .filter-tree-style-alnat .list-group > .list-group-item.level-0.item-selected > .link-childless img {
      background-color: var(--primary);
      border-color: var(--primary);
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-childless {
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
      background-color: var(--secondary);
      color: #fff;
      border-radius: 100px;
      font-size: 22px;
      padding: 20px 20px 20px 75px;
    }
    .filter-tree-style-alnat .list-group > .list-group-item.level-0 > .link-childless img {
      background-color: var(--secondary);
      border: 3px solid var(--secondary);
      border-radius: 50%;
      width: 66px;
      height: 66px;
      object-fit: none;
      position: absolute;
      top: 0;
      left: 0;
    }
    .filter-tree-style-alnat .list-group .level-1 .link-desktop .text-href:before, .filter-tree-style-alnat .list-group .level-1 .link-movil .text-href:before, .filter-tree-style-alnat .list-group .level-1 .link-desktop .text-collapsable:before, .filter-tree-style-alnat .list-group .level-1 .link-movil .text-collapsable:before {
      color: var(--primary);
      content: "•";
    }
    .filter-tree-style-alnat .list-group .level-1 .link-desktop a, .filter-tree-style-alnat .list-group .level-1 .link-movil a {
      color: #333333;
      font-weight: 500;
    }
    .filter-tree-style-alnat .list-group .level-1 .link-desktop a:hover, .filter-tree-style-alnat .list-group .level-1 .link-movil a:hover {
      color: var(--primary);
    }
    .filter-tree-style-alnat .list-group .level-1 .link-desktop .icon-href, .filter-tree-style-alnat .list-group .level-1 .link-movil .icon-href {
      right: 10px;
    }
    .filter-tree-style-alnat .list-group .level-1 .link-childless {
      color: #333333;
      font-weight: 500;
    }
    .filter-tree-style-alnat .list-group .level-1 .link-childless:hover {
      color: var(--primary);
    }
    .filter-tree-style-alnat .list-group .level-2 {
      border: 0;
    }
    .filter-tree-style-alnat .list-group .level-2 .link-childless {
      height: 20px;
    }
    .filter-tree-style-alnat .list-group .level-2 .link-childless:before {
      content: "-";
    }
    .filter-tree-style-alnat .list-group .level-2 .link-desktop, .filter-tree-style-alnat .list-group .level-2 .link-movil {
      height: 20px;
    }
    .filter-tree-style-alnat .list-group .level-2 .link-desktop .text-href:before, .filter-tree-style-alnat .list-group .level-2 .link-movil .text-href:before, .filter-tree-style-alnat .list-group .level-2 .link-desktop .text-collapsable:before, .filter-tree-style-alnat .list-group .level-2 .link-movil .text-collapsable:before {
      content: "-";
    }
    .filter-tree-style-alnat .list-group .level-3 .link-childless:before {
      content: none;
    }
    .filter-tree-style-alnat .list-group .level-3 .link-desktop .text-href:before, .filter-tree-style-alnat .list-group .level-3 .link-movil .text-href:before, .filter-tree-style-alnat .list-group .level-3 .link-desktop .text-collapsable:before, .filter-tree-style-alnat .list-group .level-3 .link-movil .text-collapsable:before {
      content: none;
    }

  </style>
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