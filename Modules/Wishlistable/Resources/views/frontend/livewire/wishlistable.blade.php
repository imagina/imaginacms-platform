<div class="table-responsive">
	@include('isite::frontend.partials.preloader')
	<table class="table table-bordered table-shape">
		<thead>
		<tr>
			<th>{{trans("wishlistable::wishlistables.table.image")}}</th>
			<th>{{trans("wishlistable::wishlistables.table.item")}}</th>
			<th>{{trans("wishlistable::wishlistables.table.action")}}</th>
		</tr>
		</thead>
		<tbody>
		@foreach($wishlist as $item)
			@if(isset($item->entity))

			<tr>
				<td>
					<a href="{{$item->url}}">

						<img v-if="" src="{{$item->entity->mediaFiles->mainimage->relativeSmallThumb}}" alt="{{$item->entity->name ?? $item->entity->title}}"
							 class="img-responsive img-fluid" style="width:100px;height:auto;">
					</a>

				</td>

				<td><a href="{{$item->url}}">{{$item->entity->name ?? $item->entity->title}} </a></td>

				<td>

					<a title="Eliminar de la lista de deseos" wire:click="deleteFromWishlist({{$item->id}})"
					   class="cart text-primary cursor-pointer">
						<i class="fa fa-trash" style="margin: 0 5px;"></i>
					</a>
				</td>
			</tr>

			@endif
		@endforeach
		@if(empty($wishlist))
		<tr>
			<td class="text-center" colspan="4">{{trans("wishlistable::wishlistables.messages.noItems")}}</td>
		</tr>
		@endif
		</tbody>
	</table>
</div>
