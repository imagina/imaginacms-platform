<div class="searchLayout4">
  <a class="btn-search" data-toggle="modal" data-target="#modalSearch4">
    <i class="fa fa-search"></i>
  </a>
  <div id="modalSearch4" class="modal fade p-0" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-0 bg-transparent border-0">
        <div class="modal-header border-0">
          <a type="button" class="close text-white px-0" data-dismiss="modal" data-backdrop="false" aria-label="Close"
             style="opacity: 1;">
            <i class="fa fa-close"></i>
          </a>
        </div>
        <div class="modal-body bg-white">
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



