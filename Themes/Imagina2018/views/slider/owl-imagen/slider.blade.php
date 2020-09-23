
<div id="{{$slider->system_name}}" class="owl-carousel owl-theme">
	@include('slider.owl-imagen.slides', ['slider' => $slider])
</div>
@section('scripts-owl')

    <script type="text/javascript">
	  	$(document).ready(function() {
	        var owl = $('#{{$slider->system_name}}');
	        owl.owlCarousel({
	        margin: 60,
	        nav: true,
	        loop: true,
            dots: false,
	        lazyContent: false,
	        autoplay: true,
	        autoplayHoverPause: true,
	        navText: [``,``],
	        responsive: {
	          0: {
	            items: 1
	          },
	          768: {
	            items:  1
	          },
	          1024: {
	            items: 1 
	          }
	        }
	      })
	    })
	</script>

	@parent
@stop

