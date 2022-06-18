<div class="searchLayout3">
  <a class="btn-search" data-toggle="modal" data-target="#modalSearch3">
    <i class="fa fa-search"></i>
  </a>
  <div id="modalSearch3" class="modal fade p-0" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content rounded-0">
        <div class="modal-body px-4">
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
