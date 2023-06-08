<div class="wishlist">

@if($showButton)
	<a href="{{\URL::route(\LaravelLocalization::getCurrentLocale() . '.wishlistable.wishlist.index')}}" class="mx-1">
		@if(!empty($quantity))
		   <span class="quantity text-dark">
					 {{  $quantity  }}
      </span>
		@endif
		<i class="fa fa-heart" aria-hidden="true"></i>
	</a>
@endif
</div>
