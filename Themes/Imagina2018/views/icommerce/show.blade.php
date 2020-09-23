
@extends('layouts.master')

@section('meta')
    <meta name="title"
          content="{{isset($product->options->meta_title)?$product->options->meta_title :$product->title}}">
    <meta name="keywords" content="{!!isset($product->options->meta_keyword) ? $product->options->meta_keyword : ''!!}">
    <meta name="description"
          content="{!!isset($product->options->meta_description) ? $product->options->meta_description : $product->summary!!}">
    <meta name="robots"
          content="{{isset($product->options->meta_robots)?$product->options->meta_robots : 'INDEX,FOLLOW'}}">
    <!-- Schema.org para Google+ -->
    <meta itemprop="name"
          content="{{isset($product->options->meta_title)?$product->options->meta_title :$product->title}}">
    <meta itemprop="description"
          content="{!!isset($product->options->meta_description) ? $product->options->meta_description : $product->summary !!}">
    <meta itemprop="image"
          content=" {{url($product->options->mainimage ?? 'modules/icommerce/img/product/default.jpg') }}">
    <!-- Open Graph para Facebook-->

    <meta property="og:title"
          content="{{isset($product->options->meta_title)?$product->options->meta_title :$product->title}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="{{url($product->slug)}}"/>
    <meta property="og:image"
          content="{{url($product->options->mainimage ?? 'modules/icommerce/img/product/default.jpg')}}"/>
    <meta property="og:description"
          content="{!!isset($product->options->meta_description) ? $product->options->meta_description : $product->summary !!}"/>
    <meta property="og:site_name" content="{{Setting::get('core::site-name') }}"/>
    <meta property="og:locale" content="{{config('asgard.iblog.config.oglocal')}}">
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ Setting::get('core::site-name') }}">
    <meta name="twitter:title"
          content="{{isset($product->options->meta_title)?$product->options->meta_title :$product->title}}">
    <meta name="twitter:description"
          content="{!!isset($product->options->meta_description) ? $product->options->meta_description : $product->summary !!}">
    <meta name="twitter:creator" content="">
    <meta name="twitter:image:src"
          content="{{url($product->options->mainimage ?? 'modules/icommerce/img/product/default.jpg')}}">

@stop

@section('title')
    {{ $product->title }} | @parent
@stop
@section('content')

    <div id="content_preloader" class="mt-4">
        <div id="preloader"></div>
    </div>



    <div id="content_show_commerce" class="">
        <!-- MIGA DE PAN  -->
         <!-- ======== Breadcrumb and title ======== -->


    <!-- ======== End Breadcrumb and title ======== -->
        
          @component('partials.widgets.breadcrumb')
            @slot('titulo',  $product->category->title )
            <li class="breadcrumb-item" v-if="categoryParent"><a :href="url+'/'+categoryParent.slug">@{{categoryParent.title}}</a></li>
            <li class="breadcrumb-item active" v-if="category"><a :href="url+'/'+category.slug">@{{category.title}}</a></li>
          @endcomponent
            

         <div class="container mt-5">
          <div class="row site-content">
            
            <!-- CONTENT -->    
            <div class="col-12">
              <div class="row ">
                <div class="col-12 col-md-7">
                  @include('icommerce.widgets.gallery')

                </div>
                <div class="col-12 col-md-5 informacion">
                  @include('icommerce.widgets.information')

                  
                </div>
              </div>
              <div class="row">
               <div class="col-12">

                <h4>Caracteristicas</h4>
                <hr>
                <div class="summary"  :inner-html.prop="product.description | truncate(200, '...')"></div>
               </div>
              </div>
              
              

          </div>
        </div>
        <div class="py-5 bg-light">
            <div class="container">
                <div class="row"> 
                    <div class="col-12">
                      <h3>También te Puede Interesar</h3>  
                    </div>
                  <div class="col-12 relacionados my-5">
                      
                      <carousel-relacionados  titulo="Productos Similares" url='{{url("/")}}/api/icommerce/v3/products?filter={"categories":[{{$product->category->id}}],order":{"field":"created_at","way":"desc"}}&take=10' ></carousel-relacionados>
                  </div>
                </div>
            </div>

        </div>
      </div>
@stop

@section('scripts')
    @parent
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin  ="anonymous"></script>
    <script>
        /********* VUE ***********/
        var vue_show_commerce = new Vue({
          el: '#content_show_commerce',
          created: function () {
            this.$nextTick(function () {
              this.range_price();
              this.get_product();
              // this.get_wishlist();
              setTimeout(function () {
                $('#content_preloader').fadeOut(1000, function () {
                  $('#content_show_commerce').animate({'opacity': 1}, 500);
                });
              }, 500);
            });
          },
          mounted: function () {
            
            bus.$on('category-e', (item) => {
              this.loadCategory(item);
            });


          },

          data: {
            path: '{{ route('api.icommerce.products.show',[$product->id]) }}',
            product: '',
            basePrice: 0,
            product_gallery: [],
            products: [],
            products_children: false,
            products_children_cart: [],
            related_products: false,
            quantity: 1,
            currency: '',
            url:icommerce.url,
            /*wishlist*/
            wishList:false,
            products_wishlist: [],
            user:{!! !empty($user)? $user :0 !!},
            product_comments: [],
            count_comments: 0,
            product_parent: false,
            products_brother: false,
            
            index_product_option_value_selected:"select",
            option_type:null,
            option_value:'',
            breadcrumb: [],
            category:{},
            categoryParent:{},
            categories: [], /*SUBCATEGORIAS*/
            sending_data: false,
            currencysymbolleft: icommerce.currencySymbolLeft,
            currencysymbolright: icommerce.currencySymbolRight,
            productOptValueSelected:[],
            /*paginacion*/
            prev:'#',
            rangeurl:[],
            next:'#',
            /*rango de precio*/
                min_price: 0,
                max_price: 999999,
                v_max: false,
                v_min: false,

          },
          filters: {
            numberFormat: function (value) {
              return parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
            },
               truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
          },
          methods: {
            range_price: function () {
                var s_slider = $("#slider-range");
                var min = this.min_price;
                var max = this.max_price;

                if (this.v_max) {
                  this.v_min = s_slider.slider("values", 0);
                  this.v_max = s_slider.slider("values", 1);
                  s_slider.slider("destroy");
                } else {
                  this.v_max = max;
                  this.v_min = min;
                }

                var v_max = this.v_max;
                var v_min = this.v_min;

                s_slider.slider({
                  range: true,
                  min: min,
                  max: max,
                  values: [v_min, v_max],
                  slide: function (event, ui) {
                    $("#min").text("$" + ui.values[0]);
                    $("#max").text("$" + ui.values[1]);
                  },
                  create: function (event, ui) {
                    $("#min").text("$" + v_min );
                    $("#max").text("$" + v_max);
                  },
                  change: function (event, ui) {
                    console.log(ui.values);
                  window.location.href=icommerce.url+'/productos?min='+ui.values[0]+'&max='+ui.values[1];      
                  }
                });
              },
            getProducts(values){
                  //window.location.href=icommerce.url+'/productos';      
                  },
            loadCategory(indexCategory){
              window.location.href=this.url+'/'+indexCategory.slug;
            },


            /* actualizar precio de producto */
            update_product: function (indexOption, indexValue){
              // console.log(indexOption, indexValue);
              vue_show_commerce.option_type=vue_show_commerce.product.productOptions[indexOption].type;
              if(vue_show_commerce.index_product_option_value_selected!="select"){
                vue_show_commerce.option_value=vue_show_commerce.product.productOptions[indexOption].optionValue;
                option=vue_show_commerce.product.optionValues[indexValue];
                // console.log(option);
                if(parseFloat(option.price)!=0.00){
                  if(option.pointsPrefix=="+"){
                    console.log('base price');
                    console.log(this.basePrice);
                    console.log('option price');
                    console.log(option.price);
                    /*
                    vue_show_commerce.product.price=parseFloat(vue_show_commerce.product.price)+parseFloat(option.price);
                    */
                    vue_show_commerce.product.price=parseFloat(this.basePrice)+parseFloat(option.price);
                    // console.log(vue_show_commerce.product.price);
                    this.productOptValueSelected=[option];
                  }
                }
              }
            },
            /* obtiene los productos */
            get_product: function () {
              axios({
                method: 'Get',
                responseType: 'json',
                url: this.path,
                params: {
                  include: 'categories,productOptions,optionValues,category,wishlists,category.parent',
                }
              }).then(function (response) {

                vue_show_commerce.product = response.data.data;
                vue_show_commerce.basePrice = response.data.data.price;
                vue_show_commerce.categories = response.data.data.categories;
                vue_show_commerce.product_gallery = response.data.data.gallery;
                vue_show_commerce.currency = "$";
                vue_show_commerce.category = response.data.data.category;
                vue_show_commerce.categoryParent = response.data.data.category.parent;

              });

            },

            /*change quantity, product children*/
            check_children: function (tr, operation, product) {
              (operation === '+') ?
              product.quantity_cart < parseInt(product.quantity) ?
              product.quantity_cart++ :
              this.alerta("{{trans('icommerce::products.alerts.no_more')}}", "warning")
              :
              false;
              (operation === '-') ?
              (product.quantity_cart >= 1) ?
              product.quantity_cart-- :
              this.alerta("{{trans('icommerce::products.alerts.no_zero')}}", "warning")
              :
              false;

              this.save_product_children(product.quantity_cart, product);
            },

            /*save/update/delete product for add to cart*/
            save_product_children: function (quantity, product) {
              var products = this.products_children_cart;
              var pos = -1;

              if (products.length >= 1) ;
              {
                $.each(products, function (index, item) {
                  item.id === product.id ? pos = index : false;
                });
              }

              if (parseInt(quantity)) { /*add/update item*/


                pos >= 0 ?
                this.products_children_cart[pos] = product :
                this.products_children_cart.push(product);

              } else if (!parseInt(quantity) && pos !== -1) {/*delete item*/
                this.products_children_cart.splice(pos, 1);
              }
            },

            /*agrega el producto al carro de compras*/
            addCart: function (data) {
              vue_show_commerce.sending_data = true;
              vue_carting.addItemCart(data.id,data.name,data.price,this.quantity,this.productOptValueSelected);
              vue_show_commerce.quantity = 1;
              vue_show_commerce.sending_data = false;

            },

            
            /*get comments of product*/
            get_comments: function () {
              axios({
                method: 'Get',
                responseType: 'json',
                url: this.path
              }).then(function (response) {
                vue_show_commerce.product_comments = response.data.product_comments;
                vue_show_commerce.count_comments = response.data.count_comments;
              });
            },

            /*alertas*/
            alerta: function (menssage, type) {
              toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": 400,
                "hideDuration": 400,
                "timeOut": 4000,
                "extendedTimeOut": 1000,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
              };
              toastr[type](menssage);
            }
          }
        });
    </script>



    <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

  @stop
