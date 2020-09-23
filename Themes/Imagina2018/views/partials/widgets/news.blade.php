@if(!empty(getPostsList(0,3,1)))<!--offiset, Limites, idcategoria(-1 para todo los pots) -->
    <div class="impost"><!-- Impost -->
        <div id="carrusel-news" class="owl-carousel owl-theme" data-ride="carousel-new">  <!-- Carrusel -->
                <div class="item active"><!-- item-->
                    <div class="row">
                    @foreach( posts(1)->posts as $post)
                            <div class="col-xs-12 col-sm-4">
                                    <div class="bgimg">
                                        <a href="{{ $post->url }}">
                                            @if($post->options)
                                            <img class="image img-responsive" src="{{URL(str_replace('.jpg','_mediumThumb.jpg',$post->options->mainimage))}}"/>
                                            @endif
                                        </a>
                                    </div>
                                    <div class="content post">
                                        <div class="create-at">
                                            {!! strftime("%A %e %B %Y", strtotime($post->created_at)) !!}
                                        </div>
                                        <h2>{{ $post->title}}</h2>
                                        <div class="extrac">
                                            {!!$post->summary !!}...
                                        </div>
                                    </div>
                                    <div class="read-more">
                                        <a href="{{ $post->url }}">Leer más</a>
                                    </div>
                            </div>
                    @endforeach
                    </div>
                </div><!-- item-->
            </div><!-- Carrusel -->
        </div><!-- Impost -->
@endif

@section('scrips')
<script id="owlcarusel">
    $('.carrusel-news').owlCarousel({
        loop:true,
        margin:10,
        responsiveClass:true,
        autoplay:true,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            500:{
                items:2,
                nav:false
            },
            992:{
                items:3,
                nav:true,
                loop:false
            }
        }
    })
</script>
@endsection