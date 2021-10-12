<div class="searchLayout3">

    <a class="btn-search" data-toggle="modal" data-target="#modalSearch3">
        <i class="fa fa-search"></i>
    </a>

    <div id="modalSearch3" class="modal fade p-0" tabindex="-1"  aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content rounded-0">


                <div class="modal-body px-4">


                    <div class="search-element py-4">
                        <div id="content_searcher3" class="dropdown {{ $this->search ? 'show' : '' }}">
                            <!-- input -->
                            <div id="dropdownSearch3"
                                 data-toggle="dropdown"
                                 aria-haspopup="true"
                                 aria-expanded="false"
                                 role="button"
                                 class="input-group">
                                <div class="input-group-append">
                                    <button class="btn"  wire:click="goToIndex" type="submit" id="button-search3">
                                        <i class="{{ $icon }}"></i>
                                    </button>
                                </div>
                                <input type="text" id="input_search3" wire:model.debounce.500ms="search" autocomplete="off"
                                       wire:keydown.enter="goToIndex"
                                       class="form-control"
                                       placeholder="{{ $placeholder }}"
                                       aria-label="{{ $placeholder }}" aria-describedby="button-search3" />
                                <div class="input-group-append">
                                    <button class="btn" data-dismiss="modal" data-backdrop="false" aria-label="Close" type="submit">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- dropdown search result -->
                            <div id="display_result3"
                                 class="dropdown-menu w-100 rounded-0 p-3 m-0 overflow-auto {{ $this->search && !request()->has('search') ? 'show' : '' }}"
                                 aria-labelledby="dropdownSearch3"
                                 style="z-index: 999999;max-height: 480px">
                                @if(!empty($search))
                                    @if(count($results) > 0)
                                        <div>
                                            @foreach($results as $item)
                                                <div class="cart-items px-3 mb-3"  wire:key="{{ $loop->index }}">
                                                    <!--Shopping cart items -->
                                                    <div class="cart-items-item row">

                                                        <!-- image -->
                                                        <div class="col-auto px-0">
                                                            <x-media::single-image :alt="$item->title"
                                                                                   :title="$item->title"
                                                                                   :isMedia="true"
                                                                                   :url="$item->url"
                                                                                   :mediaFiles="$item->mediaFiles"
                                                                                   imgStyles="object-fit: contain; height: auto; width: 100px;" />
                                                        </div>
                                                        <!-- dates -->
                                                        <div class="col">
                                                            <!-- title -->
                                                            <h6 class="mb-0">
                                                                <a href="{{ $item->url }}"
                                                                   class="text-dark">
                                                                    {{ $item->title }}
                                                                </a>
                                                            </h6>
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
