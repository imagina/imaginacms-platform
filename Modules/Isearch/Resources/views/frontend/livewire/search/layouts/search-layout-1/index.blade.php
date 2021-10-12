<div id="searchLayout1">
    <a data-toggle="modal" data-target="#searchModal"
       class="btn btn-link text-secondary icon cursor-pointer">
        <i class="fa fa-search"></i>
    </a>
    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <x-isite::logo imgClasses="text-center d-inline-block search-logo" />
                    </div>
                    <h5 class="text-center my-4 font-weight-bold">
                        {{ $title }}
                    </h5>
                    <div id="search-box">
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
                                            <div class="input-group-append">
                                                <button class="btn btn-primary px-3 " wire:click="goToIndex" type="submit" id="button-addon2">
                                                    <i class="{{ $icon }}"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- dropdown search result -->
                                    <div id="display_result"
                                         class="dropdown-menu w-100 rounded-0 py-3 m-0 overflow-auto {{ $this->search ? 'show' : '' }}"
                                         aria-labelledby="dropdownSearch"
                                         style="z-index: 999999;max-height: 480px;">
                                        @if(!empty($search))
                                            @if(count($results) > 0)
                                                <div>
                                                    @foreach($results as $item)
                                                        <div class="px-3 mb-3" wire:key="{{ $loop->index }}">
                                                            <!--Shopping cart items -->
                                                            <div class="row" style="max-height: 70px">

                                                                <!-- image -->
                                                                <!-- image -->
                                                                <div class="col-3">
                                                                    <x-media::single-image :alt="$item->title"
                                                                                           :title="$item->title"
                                                                                           :isMedia="true"
                                                                                           :url="$item->url"
                                                                                           :mediaFiles="$item->mediaFiles"
                                                                                           imgClasses="cover-img"/>

                                                                </div>
                                                                <!-- dates -->
                                                                <div class="col-9">
                                                                    <!-- title -->
                                                                    <h5 class="mb-0">
                                                                        <a href="{{ $item->url }}"
                                                                           class="font-weight-bold text-capitalize">
                                                                            {{ $item->title }}
                                                                        </a>
                                                                    </h5>
                                                                    @if(isset($item->category->title))
                                                                        <h6 class="mb-0">
                                                                            <a href="{{ $item->category->url }}"
                                                                               class="text-capitalize">
                                                                                {{ $item->category->title }}
                                                                            </a>
                                                                        </h6>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @endforeach
                                                </div>
                                            @else
                                                <h6 class="text-primary text-center">
                                                    {{ trans('isearch::common.index.Not Found') }}
                                                </h6>
                                            @endif
                                        @else
                                            <h6 class="text-primary text-center">
                                                {{ trans('isearch::common.index.Not Found') }}
                                            </h6>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
