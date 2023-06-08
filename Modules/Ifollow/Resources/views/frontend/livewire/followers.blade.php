@if($isFollowing)
    <button wire:click="deleteFollower" type="button" class="btn btn-info rounded-pill d-block">
        Dejar de seguir
    </button>
@else
    <button wire:click="setNewFollower" type="button" class="btn btn-info rounded-pill d-block">
        Seguir
    </button>
@endif
