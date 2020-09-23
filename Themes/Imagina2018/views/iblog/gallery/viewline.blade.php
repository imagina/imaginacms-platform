@if(count($post->gallery) > 0)

    <div class="gallery">
        <div class="owl-carousel owl-theme">
            <div class="item">

                    <a href="{{$post->mainimage->path}}" data-fancybox="gallery">
                        <img src="{{$post->mainimage->path}}" alt="Gallery Image">
                    </a>

                </div>
            @foreach($post->gallery as $image)

                <div class="item">

                    <a href="{{$image->path}}" data-fancybox="gallery">
                        <img src="{{$image->path}}" alt="Gallery Image">
                    </a>

                </div>
                
            @endforeach
        </div>
    </div>
@else
    <a href="{{$post->mainimage->path}}" data-fancybox="gallery">
        <img src="{{$post->mainimage->path}}" alt="Gallery Image">
    </a>

@endif

@section('scripts')
    <script>
        $(document).ready(function(){
            var owl = $('.gallery .owl-carousel');

            owl.owlCarousel({
                margin: 30,
                nav: false,
                dot:false,
                loop: false,
                lazyContent: true,
                autoplay: true,
                autoplayHoverPause: true,
                navText: ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
                responsive: {
                    0: {
                        items: 1
                    },
                    640: {
                        items: 2
                    },
                    992: {
                        items: 3
                    }
                }
            });

        });
    </script>

    @parent

@stop