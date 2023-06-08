
<div class="gallery-img mb-4">
    <div class="owl-carousel owl-theme">
        <div class="item">
            <img class="img-fluid w-100" data-fancybox="gallery" src="{{ Theme::url('img/artista.jpg') }}" alt="">
        </div>
        <div class="item">
            <img class="img-fluid w-100" data-fancybox="gallery" src="{{ Theme::url('img/artista1.png') }}" alt="">
        </div>
        <div class="item">
            <img class="img-fluid w-100" data-fancybox="gallery" src="{{ Theme::url('img/artista2.png') }}" alt="">
        </div>
        <div class="item">
            <img class="img-fluid w-100" data-fancybox="gallery" src="{{ Theme::url('img/artista1.png') }}" alt="">
        </div>
    </div>
</div>


@section('scripts')
    <script>
        $(document).ready(function () {
            var owl = $('.gallery-img .owl-carousel');

            owl.owlCarousel({
                margin: 0,
                nav: true,
                loop: true,
                dots: true,
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
