@php
    $componentName = $componentConfig["systemName"];
    $nameSpace = $componentConfig["nameSpace"];
    $attributes = $componentConfig["attributes"];
    if($componentName=='ibuilder::block-custom')  {
       $attributes['image'] = $blockConfig->mediaFiles->custommainimage ?? null;
       $attributes['gallery'] = $blockConfig->mediaFiles->customgallery ?? null;
    }
    $block = $blockConfig->attributes->mainblock;
@endphp
<section id="block{{$block->id ?? $id}}"
         class="{{$block->blockClasses ?? $blockClasses}}">

  @if($editLink)
    <x-isite::edit-link
      link="{{$editLink}}"
      tooltip="{{$tooltipEditLink}}"
      icon="fas fa-palette"
      bottom="0"
      left="20px !important"
      top="unset !important"
      right="unset !important"
      bgColor="#c700db"
    />
  @endif

  @if($block->overlay ?? $overlay)
    <!--Overlay-->
    <div id="overlay{{$block->id ?? $id}}"></div>
  @endif
  <div id="container{{$block->id ?? $id}}"
       class="{{$block->container ?? $container}}">
    <div class="row {{$block->row ?? $row}}">
      <div class="{{$block->columns ?? $columns}} ">

        <!--Dynamic Component-->
        <div id="component{{$block->id ?? $id}}">
          <!--blade Component-->
          @if($componentType == "blade")
            @if(!empty($nameSpace))
                <?php
                $hash = sha1($nameSpace);
                if (isset($component)) {
                  $__componentOriginal{$hash} = $component;
                }
                $component = $__env->getContainer()->make($nameSpace, $attributes ?? []);
                $component->withName($componentName);
                if ($component->shouldRender()):
                  $__env->startComponent($component->resolveView(), $component->data());
                  if (isset($__componentOriginal{$hash})):
                    $component = $__componentOriginal{$hash};
                    unset($__componentOriginal{$hash});
                  endif;
                  echo $__env->renderComponent();
                endif;
                ?>
            @endif
          @endif
          <!--Livewire Component-->
          @if($componentType == "livewire")
            @livewire($componentName, $attributes)
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
<style>

    #block{{$block->id ?? $id}}  {
        position: {{$block->position ?? ''}};
        top: {{$block->top ?? ''}};
        left: {{$block->left ?? ''}};
        right: {{$block->right ?? ''}};
        bottom: {{$block->bottom ?? ''}};
        z-index: {{$block->zIndex ?? ''}};
        width: {{$block->width ?? ''}};
        height: {{$block->height ?? ''}};

        @if($block->backgroundColor)
        background: {{$block->backgroundColor}};
        @elseif(isset($block->backgrounds))
        background-image: url({{$blockConfig->mediaFiles->blockbgimage->extraLargeThumb ?? ''}});
        background-position: {{$block->backgrounds->position}};
        background-size: {{$block->backgrounds->size}};
        background-repeat: {{$block->backgrounds->repeat}};
        background-attachment: {{$block->backgrounds->attachment}};
        background-color: {{$block->backgrounds->color}};
        @endif
    }
    @if($block->blockStyle)
          {!!$block->blockStyle!!}
    @endif

    @if(!empty($block->overlay))
    #overlay{{$block->id ?? $id}} {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0%;
        right: 0%;
        background: {{$block->overlay}};
    }
    @endif
</style>
