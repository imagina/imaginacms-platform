<div class="items-list {{$itemMainClass}}-list">
	
	@include('isite::frontend.livewire.index.top-content.index')
	
	<div class="items {{$itemMainClass}}s">
		
		@include('isite::frontend.partials.preloader')
		
		@if(isset($items) && count($items)>0)
			
			<div class="items-list-wrapper {{$wrapperClass}}">
				
				@include("isite::frontend.livewire.index.partials.items")

				@livewire("isite::item-modal", array_merge($itemModal,["params" => $params,"repository" => $repository]),key(rand()))
				
			</div>
			
			@if($pagination["show"])
				@include('isite::frontend.livewire.index.pagination.index')
			@endif

		@else
			<div class="row">
				<div class="no-items alert alert-danger my-5" role="alert">
					{{trans('isite::common.messages.no items')}}
				</div>
			</div>
		@endif
	
	
	</div>

</div>

@section('scripts')
	@parent
	<script type="text/javascript">
		
		document.addEventListener('DOMContentLoaded', function () {
			window.livewire.emit('itemListRendered',{!! json_encode($params) !!});
		});
		
		/*
		* Function Back Top
		*/
		function itemsListBackToTop() {
			let positionY = window.pageYOffset;
			let scrollPos = $(".{{$itemMainClass}}-list").offset().top;
			if (positionY > scrollPos)
				$("html, body").animate({scrollTop: scrollPos}, "slow");
		}
		
		/*
  		* Event on Click Pagination
  		*/
		$(document).on('click', '.page-link-scroll', function (e) {
			itemsListBackToTop();
			return false;
		});
		
		
		/*
    	* Document Ready Gral
    	*/
		jQuery(document).ready(function($) {

			@if(isset($itemListLayout) && $itemListLayout=='carousel')
	    		$('#idCarousel_{{$this->id}}').owlCarousel({!! json_encode($carouselAttributes) !!})
			@endif

			/*
    		* Listener Item List Rendered
    		*/
    		var nameEmit = 'itemListRendered';
    		if(@this.uniqueItemListRendered){
    			nameEmit = 'itemListRendered_{{$this->id}}'
    		}

			Livewire.on(nameEmit, function () {

				if(@this.itemListLayout!="masonry" && @this.itemListLayout!="carousel" ){
					itemsListBackToTop();
				}

				if(@this.itemListLayout=="masonry"){
					window.bricklayer = new window.Bricklayer(document.querySelector('.bricklayer'))
				}

				if(@this.itemListLayout=="carousel"){
					$('#idCarousel_{{$this->id}}').trigger('destroy.owl.carousel');
					$('#idCarousel_{{$this->id}}').owlCarousel({!! json_encode($carouselAttributes) !!})
				}
				
			})

		});


		/*
    	* Check is Mobile
    	*/
		function checkMobile(){
	        var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
	        if(width <= 992) {
	          return true;
	        }else{
	          return false;
	        }
	    }

	   
	    /*
    	* Check is Mobile and emit Modal
    	*/
	    function checkModal_{{$itemModal['idModal']}}(itemId){

	        var mobile = checkMobile();

	        var itemMobile = {!! $itemModal['mobile'] ? 'true' : 'false' !!}
	        var itemDesktop = {!! $itemModal['desktop'] ? 'true' : 'false' !!}

	        if(!mobile && itemDesktop){
	          window.livewire.emit('itemModalLoadData',itemId,@this.itemModal['idModal'])
	        }else{
	          if(mobile && itemMobile){
	            window.livewire.emit('itemModalLoadData',itemId,@this.itemModal['idModal'])
	          }
	        }

	    }


	</script>

@stop