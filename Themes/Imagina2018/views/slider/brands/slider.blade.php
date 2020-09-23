<div id="{{$slider->system_name}}" class="owl-carousel owl-theme">
    @include('slider.brands.slides', ['slider' => $slider, 'options'=>$options])
</div>

@section('scripts')
    @parent

    <script type="text/javascript">
        $(document).ready(function() {

            $('#{{$slider->system_name}}').owlCarousel({
                loop: true,
                margin: 20,
                dots: false,
                responsiveClass: true,
                autoplay:true,
                autoplayTimeout:2000,
                navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                    },
                    768: {
                        items: 3,
                        nav: true,
                    },
                    992: {
                        items: 6,
                        nav: true,
                    }
                }
            });

        });
    </script>

@stop