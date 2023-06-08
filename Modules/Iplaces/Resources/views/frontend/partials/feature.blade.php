
<div class="gallery-featured mb-4">
    <div class="owl-carousel owl-theme">
        <div class="item">
            <li class="list-group-item bg-light py-4">
                <div class="row align-items-center">
                    <div class="col">
                        <a href="">
                            <img class="img-sm w-100 p-1 rounded bg-white" src="{{ Theme::url('img/artista.jpg') }}" alt="Generic placeholder image">
                        </a>
                    </div>
                    <div class="col pl-0">
                        <h5 class="title my-0"><a href="">Carol G1</a></h5>
                        <p class="text">Imitadores</p>
                        <a href="" class="btn btn-primary btn-sm btn-block">Ver más</a>
                    </div>
                </div>
            </li>
            <li class="list-group-item bg-light py-4">
                <div class="row align-items-center">
                    <div class="col">
                        <a href="">
                            <img class="img-sm w-100 p-1 rounded bg-white" src="{{ Theme::url('img/artista.jpg') }}" alt="Generic placeholder image">
                        </a>
                    </div>
                    <div class="col pl-0">
                        <h5 class="title my-0"><a href="">Carol G2</a></h5>
                        <p class="text">Imitadores</p>
                        <a href="" class="btn btn-primary btn-sm btn-block">Ver más</a>
                    </div>
                </div>
            </li>

        </div>
        <div class="item">
            <li class="list-group-item bg-light py-4">
                <div class="row align-items-center">
                    <div class="col">
                        <a href="">
                            <img class="img-sm w-100 p-1 rounded bg-white" src="{{ Theme::url('img/artista.jpg') }}" alt="Generic placeholder image">
                        </a>
                    </div>
                    <div class="col pl-0">
                        <h5 class="title my-0"><a href="">Carol G3</a></h5>
                        <p class="text">Imitadores</p>
                        <a href="" class="btn btn-primary btn-sm btn-block">Ver más</a>
                    </div>
                </div>
            </li>
            <li class="list-group-item bg-light py-4">

                <div class="row align-items-center">
                    <div class="col">
                        <a href="">
                            <img class="img-sm w-100 p-1 rounded bg-white" src="{{ Theme::url('img/artista.jpg') }}" alt="Generic placeholder image">
                        </a>
                    </div>
                    <div class="col pl-0">
                        <h5 class="title my-0"><a href="">Carol G4</a></h5>
                        <p class="text">Imitadores</p>
                        <a href="" class="btn btn-primary btn-sm btn-block">Ver más</a>
                    </div>
                </div>

            </li>
        </div>

    </div>
</div>


@section('scripts')
    <script>
        $(document).ready(function () {
            var owl = $('.gallery-featured .owl-carousel');

            owl.owlCarousel({
                margin: 0,
                nav: true,
                loop: true,
                dots: false,
                lazyContent: true,
                autoplay: true,
                autoplayHoverPause: true,
                navText: ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
                responsive: {
                    0: {
                        items: 1
                    },
                    640: {
                        items: 1
                    },
                    992: {
                        items: 1
                    }
                }
            });

        });
    </script>

    @parent

@stop
