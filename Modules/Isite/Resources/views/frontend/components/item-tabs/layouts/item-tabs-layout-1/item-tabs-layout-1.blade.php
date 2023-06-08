<section id="contentTaps">
  <h3 class="text-center title-1">{{$title}}</h3>
  <h5 class="text-center subtitle">{{$subtitle}}</h5>
 
  @if(isset($categories) && count($categories)>0)
    <ul class="nav nav-tabs products-tabs" role="tablist">
        @php($counter = 0)
        @foreach($categories as $itemTab)
          @php($counter++)
          @php($counter == 1 ? $state = 'active' : $state = ' ')
          <li class="nav-item">
            <a class="nav-link {{$state}}" id="product-tab-{{$itemTab->id}}"
               data-toggle="tab" href="#tab-{{$itemTab->id}}" role="tab" aria-controls="home" aria-selected="true">
              {{$itemTab->title}}
            </a>
          </li>
        @endforeach
    </ul>

    <div class="tab-content border-top border-bottom border-white">
      @php($counter = 0)
      @foreach($categories as $item)

        @if(isset($componentUse) && $componentUse != 'item-list')
          @php($counter++)
          @php($counter == 1 ? $state = 'show active' : $state = ' ')
          <div class="tab-pane fade {{$state}}" id="tab-{{$item->id}}" role="tabpanel"
               aria-labelledby="product-tab-{{$item->id}}">
            <x-isite::carousel.owl-carousel
                    id="carouselCategoryHome{{$item->id}}"
                    repository="{{$componentRepository}}"
                    :params="['take' => 8, 'filter' => ['order' => ['way' => 'desc'],$componentFilter => $item->id]]"
                    :margin="$componentMargin"
                    :itemsBySlide="$componentItemsBySlide"
                    :navText="$componentNavText"
            />
          </div>
        @else
          @php($counter++)
          @php($counter == 1 ? $state = 'show active' : $state = ' ')
          <div class="tab-pane fade {{$state}}" id="tab-{{$item->id}}" role="tabpanel"
               aria-labelledby="product-tab-{{$item->id}}">
            <livewire:isite::items-list
                    :moduleName="$componentModuleName"
                    itemComponentName="$componentName"
                    :itemComponentNamespace="$componentNameSpace"
                    :configLayoutIndex="$componentConfigLayoutIndex"
                    :itemComponentAttributes="$componentItemComponentAttributes"
                    :entityName="$componentEntityName"
                    :repository="$componentRepository"
                    :showTitle="false"
                    :params="['filter' => [$componentFilter => $item->id ?? null, 'withoutInternal' => true]]"
                    :responsiveTopContent="['mobile'=>false,'desktop'=>false]"
            />
          </div>
        @endif
      @endforeach
    </div>
  @else
    <div class="alert alert-danger my-5 w-75 mx-auto" role="alert">
      No existen categorias destacadas para los Tabs
    </div>
  @endif
</section>
