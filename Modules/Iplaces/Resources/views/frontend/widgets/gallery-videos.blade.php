@if($place->videos)
    <div id="{{$place->id}}-video-place" class="owl-carousel owl-theme owl-video-place">
        @foreach($place->videos as $video)
            <div class="item">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="{{youtubeID($video)}}" allowfullscreen></iframe>
                </div>
            </div>
        @endforeach
    </div>

@section('scripts')
    @parent


    <script type="text/javascript">
        $(document).ready(function () {
            var owl = $('#{{$place->id}}-video-place');

            owl.owlCarousel({
                margin: 0,
                nav: false,
                dots: true,
                loop: true,
                lazyContent: true,
                autoplay: false,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    }
                }
            });
        });
    </script>
@stop


@endif






















