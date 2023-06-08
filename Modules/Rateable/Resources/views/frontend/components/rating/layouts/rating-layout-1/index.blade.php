<div id="ratingComponent" class="rating rating-layout-1">

	@if($rating>0)
		<div class="d-flex flex-row w-25">
		    <div class="star1">
		    	<i class="fa fa-star fa-lg @if($rating >= 1 ) text-warning @else text-muted @endif" aria-hidden="true"></i>
		    </div>
		  	<div class="star2">
		  		<i class="fa fa-star fa-lg @if($rating >= 2 ) text-warning @else text-muted @endif" aria-hidden="true"></i>
		  	</div>
		 	<div class="star3">
		 		<i class="fa fa-star fa-lg @if($rating >= 3 ) text-warning @else text-muted @endif" aria-hidden="true"></i>
		 	</div>
		 	<div class="star4">
		 		<i class="fa fa-star fa-lg @if($rating >= 4 ) text-warning @else text-muted @endif" aria-hidden="true"></i>
		 	</div>
		 	<div class="star5">
		 		<i class="fa fa-star fa-lg @if($rating >= 5 ) text-warning @else text-muted @endif" aria-hidden="true"></i>
		 	</div>
		</div>
    @endif
   	
</div>