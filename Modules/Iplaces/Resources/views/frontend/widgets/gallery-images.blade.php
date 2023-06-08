<div id="image-place" class="owl-carousel owl-theme owl-image-place">
    @foreach(placegallery($place->id) as $image)

        <div class="item">

                <img class="img-fluid" src="{{asset($image)}}"
                     alt="{{$place->title}}">

        </div>

    @endforeach
</div>

@section('scripts')
    @parent


    <script type="text/javascript">
        $(document).ready(function() {
            var owli = $('#image-place');

            owli.owlCarousel({

                margin: 0,
                nav: true,

                loop: true,
                lazyContent: true,
                autoplay: false,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
                responsive: {
                    0: {
                        items: 1,
                        stagePadding: 0,
                        dots: true
                    },
                    768: {
                        items: 1,
                        stagePadding: 82,
                        dots: false
                    }
                }
            });
        });
    </script>
@stop

























