<div id="searchLayout1">
{{--    {{dd($params,$showModal,$icon,$placeholder,$title)}}--}}
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
                        <livewire:isite::filter-autocomplete
                          :showModal="$showModal"
                          :icon="$icon"
                          :placeholder="$placeholder"
                          :buttonSearch="true"
                          :params="$params"
                          :title="$title"
                          :minSearchChars="$minSearchChars"
                          :goToRouteAlias="$goToRouteAlias"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>