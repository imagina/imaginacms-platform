<div id="top-content-mobile" class="options-product-list options-product-list-mobile d-lg-none">

	@include('isite::frontend.livewire.index.top-content.total-items')

	<div class="products-menu d-inline-flex">

	      <button type="button" class="products-menu__item products-menu__item--layouts">
	 		
	        @include('isite::frontend.livewire.index.top-content.mobile.change-layout')

	      </button>

	      <button type="button" class="products-menu__item products-menu__item--order">
	         <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
	         <i class="fa fa-long-arrow-down mr-1" aria-hidden="true"></i>
	         {{trans('isite::frontend.mobile.order')}} 
	      </button>

	      
	      <button data-toggle="modal" data-target="#modalFilter" type="button" class="products-menu__item products-menu__item--filters">
	         <i class="fa fa-sliders mr-1" aria-hidden="true"></i>
	         {{trans('isite::frontend.mobile.filter')}} 
	      </button>
	    
	</div>

	
	<div class="item-options item-options--order">

		<livewire:isite::filter-order-by key="filter-order-by-mobile"
		:config="config('asgard.'.$moduleName.'.config.orderBy')"
		type="radio"/>
		
	</div>
	
</div>

@section('scripts-owl')
   @parent

   <script type="text/javascript">
      $(document).ready(function () {
         
         var $orderByButton = $('.products-menu__item--order');
         var $orderByModal = $('.item-options--order');

         var $itemModalClose = $('.item-options__close');
         var body = document.body;

         $orderByButton.click(function() {
            $orderByModal.toggleClass('show');
            body.classList.toggle('overflow-hidden');
         });

         $itemModalClose.click(function () {
            $(this).parent().parent().toggleClass('show');
            body.classList.toggle('overflow-hidden');
         });


        // Check width
        var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        if(width <= 992) {
			window.onscroll = function() {checkOffset()};
		}
		
		var topcontent = document.getElementById("top-content-mobile");
		var sticky = topcontent.offsetTop;
		// Check Offset Scroll
		function checkOffset() {

		  if (window.pageYOffset > sticky) {
		    topcontent.classList.add("sticky-top-content");
		  } else {
		    topcontent.classList.remove("sticky-top-content");
		  }
		}

      });
   </script>

@stop