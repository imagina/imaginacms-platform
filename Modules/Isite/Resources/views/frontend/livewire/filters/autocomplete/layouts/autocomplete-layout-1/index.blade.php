<div id="autocompleteLayout1">
  <div id="autocomplete-box">
    <div class="search-product row no-gutters">
      <div class="col">
        <div id="content_searcher" class="dropdown {{ $this->search ? 'show' : '' }}">
          <!-- input -->
          <div id="dropdownSearch"
               data-toggle="dropdown"
               aria-haspopup="true"
               aria-expanded="false"
               role="button"
               class="input-group dropdown-toggle">
            <div class="input-group">
              <input type="text" id="input_search" wire:model.debounce.500ms="search"
                     wire:keydown.enter="goToIndex"
                     autocomplete="off"
                     class="form-control  rounded-right"
                     placeholder="{{ $placeholder }}"
                     aria-label="{{ $placeholder }}" aria-describedby="button-addon2">
              @if($buttonSearch)
                <div class="input-group-append">
                  <button class="btn btn-primary px-3 " wire:click="goToIndex" type="submit" id="button-addon2">
                    <i class="{{ $icon }}"></i>
                  </button>
                </div>
              @endif
            </div>
          </div>
          <!-- dropdown search result -->
          <div id="display_result"
               class="dropdown-menu w-100 rounded-0 py-3 m-0 overflow-auto {{ $this->search && $updatedSearchFromInput ? 'show' : '' }}"
               aria-labelledby="dropdownSearch"
               style="z-index: 999999;
    max-height: 480px;
    position: absolute;
    will-change: transform;
    top: 0px;
    left: 0px;
    transform: translate3d(0px, 40px, 0px);">
            @if(!empty($search))
              @if(count($results) > 0)
                <div>
                  @foreach($results as $item)
                    <div class="px-3 mb-3" style="max-height: 70px" wire:key="{{ $loop->index }}">
                      <!--Shopping cart items -->
                      <div class="row" style="max-height: 70px">
                        <!-- image -->
                        <!-- image -->
                        <div class="col-2 px-0">
                          <x-media::single-image :alt="$item->title ?? $item->name"
                                                 :title="$item->title ?? $item->name"
                                                 :isMedia="true"
                                                 imgStyles="
                                                  width: 100%;
                                                  height: 100%;
                                                  -o-object-fit: cover;
                                                  object-fit: cover;"
                                                 :url="$item->url ?? null"
                                                 :mediaFiles="$item->mediaFiles()"
                                                 imgClasses="cover-img"/>
                        </div>
                        <!-- dates -->
                        <div class="col-10">
                          <!-- title -->
                          <h6 class="mb-0">
                            <a href="{{ $item->url }}"
                               class="text-dark font-weight-bold text-capitalize">
                              {{ $item->title  ?? $item->name}}
                            </a>
                          </h6>
                          @if(isset($item->category->title))
                            <h7 class="mb-0">
                              <a href="{{ $item->category->url }}"
                                 class="text-dark text-capitalize">
                                {{ $item->category->title }}
                              </a>
                            </h7>
                          @endif
                        </div>
                      </div>
                    </div>
                    <hr>
                  @endforeach
                </div>
              @else
                <h6 class="text-dark text-center">
                  {{ trans('isearch::common.index.Not Found') }}
                </h6>
              @endif
            @else
              <h6 class="text-dark text-center">
                {{ trans('isearch::common.index.Not Found') }}
              </h6>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
