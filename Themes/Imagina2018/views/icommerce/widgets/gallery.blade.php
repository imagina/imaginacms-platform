
        

        <div class="" v-if="product_gallery && product_gallery.length>0">
            <div class="thumbnail-slider-container"> 
                <div id="carouselGallery" class="carousel slide image" data-ride="carousel">
                    <div class="carousel-inner h-100">
                        <div class="carousel-item h-100" v-for="(img,index) in product_gallery" v-bind:class="[ (index == 0) ? 'active' : '']">
                           <a :href="img['path']"  data-fancybox="gallery" class="bt-search"  :data-caption="product.title">
                                <img  v-bind:src="img.path"  class="img-big">
                            </a>
                        </div>
                    </div>
                    
                     {{--<ol class="carousel-indicators">                
                        <li v-for="(img,index) in product_gallery" data-target="#carouselGallery" :data-slide-to="index" :class="'list-item-'+index+' d-flex justify-content-center align-items-center'" v-bind:class="[ (index == 0) ? 'active' : '']">
                            <div :class="'dot-basic dot-'+index"></div>
                        </li>
                    </ol>--}}

                     <div class="controls">  
                         <a class="carousel-control carousel-control-prev" href="#carouselGallery" role="button" data-slide="prev">
                        {{-- <i class="fa fa-angle-left" aria-hidden="true"></i>--}}
                        </a>
                        <a class="carousel-control carousel-control-next" href="#carouselGallery" role="button" data-slide="next">
                            {{-- <i class="fa fa-angle-right" aria-hidden="true"></i>--}}
                        </a>
                   </div>

                </div>
            </div>
                <div class="row owl-image-mini" v-if="">
                  <div class="col-1 nav text-left">
                     <a class="customPrevBtn4"><i class="fa fa-angle-left"></i></a>
                  </div>
                      <div class="col-10">
                          <div class=" d-none d-sm-block overflow-hidden">
                                <div id="owl-image-mini" class="thumbnail-slider owl-carousel  owl-theme ">
                                    <div class="item" v-for="(img,index) in product_gallery" class="m-0">        
                                        <img data-target="#carouselGallery" v-bind:data-slide-to="index" v-bind:src="img.path" class="">
                                    </div>       
                                </div>
                            </div> 
                      </div>
                      <div class="col-1 nav text-right">
                        <a class="customNextBtn4"><i class="fa fa-angle-right"></i></a>
                      </div>
                </div>
                      
        </div>
        <div class="" v-else >
            <a v-if="product.mainImage['path']" :href="product.mainImage['path']" :data-fancybox="product.title" :data-caption="product.title">
                <img :src="product.mainImage['path']" class="img-fluid w-100  p-1" :alt="product.title">
            </a>
        </div>


@section('scripts-owl')

    <script type="text/javascript">
        $(document).ready(function() {
            var owl = $('#owl-image-mini');
            owl.owlCarousel({
            margin: 0,
            nav: true,
            loop: true,
            dots: false,
            lazyContent: true,
            autoplay: true,
            autoplayHoverPause: true,
            navText: ['',''],
            responsive: {
              0: {
                items: 1
              },
              768: {
                items:  3
              },
              1024: {
                items: 3
              }
            }
          })
        });

    $('.customNextBtn4').click(function() {
        $(el).trigger('next.owl.carousel');
    });

    $('.customPrevBtn4').click(function() {
        $(el).trigger('prev.owl.carousel', [300]);
    });
    </script>
    @parent
@stop

