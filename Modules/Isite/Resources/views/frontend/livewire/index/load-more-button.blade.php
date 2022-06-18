<div class="load-more-button mx-auto">

	@if($showBtnLoadMore && $pagination["type"]=="loadMore")
  		<a wire:click="loadMore" class="btn btn-primary btn-load-more">{{trans('isite::frontend.buttons.load more')}}</a>
  	@endif

  	<input wire:model="showBtnLoadMore" type="hidden" id="inputShowBtnLoadMore">
  	<input wire:model="infiniteStatus" type="hidden" id="inputInfiniteStatus">

</div>

@section('scripts-owl')
	@parent
	<script type="text/javascript">
		
	    jQuery(document).ready(function($) {
	    	
	    	function htmlToElements(html) {
			    var template = document.createElement('template');
			    template.innerHTML = html;
			    return template.content.childNodes;
			}

		    window.addEventListener('items-load-more-button', event => {
		    	
		    	// Bricklayer needed
		    	@if($itemListLayout=="masonry")
			    	var rows = htmlToElements(event.detail.newHtml);
			    	for(var value of rows.values()) {
					  window.bricklayer.append(value)
					}
				@else
					$(".items-list .items .{{$parentItemListUniqueClass}}").append(event.detail.newHtml);
				@endif


				/*
				* Validation after get new items
				*/
				@if($pagination['type']=="infiniteScroll")
					$("#inputInfiniteStatus").val(false)
				@endif
				
		    });

		    /*
		    * Event to Infinite Scroll Pagination Type
		    */
		    if(@this.pagination['type']=="infiniteScroll"){

		    	let itemListPos = $(".{{$itemMainClass}}-list").offset().top;
		    	
			   	window.onscroll = function(ev) {

			   		
			   		var inputShow = $("#inputShowBtnLoadMore").val();
			   		var inputInfinite = $("#inputInfiniteStatus").val();

			   		//console.warn("Input Load More: "+inputShow);
			   		//console.warn("Input Infinite: "+inputInfinite);

			   		/*
					* showBtnLoadMore == true = exist more elements
					* infiniteStatus == false = Request is not executting
			   		*/
			   		if(inputShow=="true" && inputInfinite=="false"){
			   			
			   			/*
			   			* innerHeight = Altura en pix del viewport
			   			* scrollY = Número de píxeles, desplazados mediante el scroll vertical.
			   			*/
			   			var currentPos = window.innerHeight + window.scrollY + itemListPos;

			   			// body.offsetHeight = alto de un elemento
			   			var currentHeight = document.body.offsetHeight/1.3;

			   			//console.warn("currentPos: "+currentPos)
			   			//console.warn("currentHeight: "+currentHeight)

				        if (currentPos >= currentHeight) {

				        	$("#inputInfiniteStatus").val(true)
				            window.livewire.emit('loadMoreButtonInfinite');
				        }
				    }
			    };
				
			}
		   
		});

	</script>

@stop				