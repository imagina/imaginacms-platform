  @extends('layouts.master')

@section('meta')
    @if(isset($category) && !empty($category))
        <meta name="description" content="{{$category->options->metadescription ?? $category->description ?? ''}}">
        <!-- Schema.org para Google+ -->
        <meta itemprop="name" content="{{$category->options->metatitle ?? $category->title ?? ''}}">
        <meta itemprop="description" content="{{$category->options->metadescription ?? $category->description ?? ''}}">
        <meta itemprop="image"
              content=" {{url($category->options->mainimage??'modules/icommerce/img/category/default.jpg')}}">
    @endif
@stop
@section('title')
    {{isset($category->title)? $category->title: 'search'}}  | @parent
@stop


@section('content')
    
    <!-- preloader -->
    <div id="content_preloader">
        <div id="preloader"></div>
    </div>
    <div id="content_index_commerce" class="icommerce">
    
    <!-- ======== Breadcrumb and title ======== -->
    @component('partials.widgets.breadcrumb')
    @slot('titulo', $category->title)
    @slot('descripcion', $category->description)
    
    @if(isset($category) && !empty($category)) 
    @if(isset($category->parent) && !empty($category->parent))
        @slot('img', $category->parent->secondaryimage->path)
        <li class="breadcrumb-item">
            <a href="{{ $category->parent->url }}">
                {{ $category->parent->title }}
            </a>
        </li>
    @else           
        @slot('img', $category->secondaryimage->path)
        <li class="breadcrumb-item active" aria-current="page">{{$category->title}}</li>                       
    @endif
  @else 
   <li class="breadcrumb-item active" aria-current="page">
       {{trans('icommerce::common.search.search_result')}} @{{criterion}}
   </li> 
  @endif
        
    @endcomponent
        
        <!-- ======== #content ======== -->
        <div class="container my-5">
          <!-- CATEGORIES -->        
          
          


          <div class="row site-content">
            <!-- SIDEBAR -->    
            <div class="sidebar width-side-open col-lg-3 ">
              <!-- FILTERS --> 
              <div class="side">@include('icommerce.widgets.categories')</div>                            
              <div class="side">@include('icommerce.widgets.range_price')</div>
            </div>
            <!-- CONTENT -->    
            <div class="col-12 col-lg-9">
              <!-- FILTERS --> 
              <div class="row justify-content-between">
                
                <div class="col-12 col-md-auto filter d-flex justify-content-between align-items-stretch">
                  <div class="border-left d-flex align-items-center col">
                    <span>@{{totalArticles}} Articulos</span>
                  </div>           
                  @include('icommerce.widgets.order_by')
                </div>
                <div class="col-12 col-md-6">
                  @include('icommerce.widgets.paginate')
                </div>
                <div class="col-12">
                  <hr>
                </div>
              </div>
              <!-- PRODUCTS -->    
              @include('icommerce.widgets.products')
              @include('icommerce.widgets.paginate')
              </div>            
              
          </div>
        </div>
    </div>
   

@stop
@section('scripts')
    @parent

    <script>
        /* =========== VUE ========== */
        const vue_index_commerce = new Vue({
            el: '#content_index_commerce',
            data: {
                /*paginador*/
                preloaded: true,
                currency: '$',
                currencySymbolLeft: icommerce.currencySymbolLeft,
                currencySymbolRight: icommerce.currencySymbolRight,
                v_pages: 1,
                ////Paginación
                p_currence: 1,//Página Actual
                pages: 1,//Cantidad de páginas
                totalArticles:0,//Total de registros
                ////Paginación
                r_pages: {
                    first: 1,
                    latest: 5
                },
                /*dates*/
                articles: [],
                categorititle:'',
                category:{!! $category ? json_encode($category) : "''"  !!},
                category_seleccionada:"",
                category_parent: {{$category->id}}, /*CATEGORIA PADRE*/
                categories: [], /*SUBCATEGORIAS*/
                queryExternalCategory:false,
                indexCategory:0,                
                criterion: '{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : ''}}',
                /*order*/
                order_check: 'all',
                
                /*order*/
                order: {
                    field: 'created_at',
                    way: 'DESC'
                },
                /*manufacturer*/
                manufacturers:[],
                manufacturer:0,
                /*rango de precio*/
                price: {
                  from: 0,
                  to: 999999
                },
                min_price: 0,
                max_price: 999999,
                min:'{{ isset($_REQUEST['min']) ? $_REQUEST['min'] : ''}}',
                max:'{{ isset($_REQUEST['max']) ? $_REQUEST['max'] : ''}}',
                v_max: false,
                v_min: false,
                /*wishlist*/
                user: {!! !empty($user)? $user :0 !!},
                
            },
            mounted: function () {
                this.preloaded = false;
                //this.category_seleccionada=this.category.id;
                this.getProducts();                
                this.range_price();
                this.getManufacturers();
                bus.$on('category-e', (item) => {
                  this.category_seleccionada=item.id;
                    this.getProducts();    
                });
                $('#content_preloader').fadeOut(1000, function () {
                    $('#content_index_commerce').animate({'opacity': 1}, 500);
                });
            },
            
            filters: {
                numberFormat: function (value) {
                    return parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                }
            },
            methods: {
              /* configuar la consulta por rango de precio */
              filter_price: function (values) {
                
                  this.price = {
                  from: values[0],
                  to: values[1]
                };
                this.getProducts();
                
              },
              /*agrega el producto al carro de compras*/
              addCart: function (item) {
                vue_carting.addItemCart(item.id,item.name,item.price);
              },

              //filtrar por rango de precio
              range_price: function () {
                var s_slider = $("#slider-range");
                if (this.v_max) {
                  this.v_min = s_slider.slider("values", 0);
                  this.v_max = s_slider.slider("values", 1);
                  s_slider.slider("destroy");
                } 
                else {
                  this.v_max = this.max_price;
                  this.v_min = this.min_price;
                }

                var v_max;
                var v_min;
                if(this.min!='' && this.max!=''){
                  v_max = this.max;
                  v_min = this.min;
                  this.price.max=this.max;
                  this.price.min=this.min;

                }else{
                  v_max = this.v_max;
                  v_min = this.v_min;  
                }
                s_slider.slider({
                  range: true,
                  min: this.min_price,
                  max: this.max_price,
                  values: [v_min, v_max],
                  slide: function (event, ui) {
                    $("#min, #min2").text("$" + ui.values[0]);
                    $("#max, #max2").text("$" + ui.values[1]);
                  },
                  create: function (event, ui) {
                    $("#min, #min2").text("$" + v_min );
                    $("#max, #max2").text("$" + v_max);
                  },
                  change: function (event, ui) {
                    console.log(ui.values)
                    vue_index_commerce.filter_price(ui.values);
                  }
                });
              },
              //obtener productos
              getProducts() {
               var filter={
                  order: this.order,
                  categoryId: this.category.id,
                  priceRange: this.price,
                };
                if(this.category_seleccionada!=""){
                    delete filter.categoryId;
                  filter.categories=this.category_seleccionada;
                }
                //filtrar por busqueda
                if(this.criterion!=""){
                  filter.search=this.criterion;
                }
                //filtrar por fabricante
                if(this.manufacturer!=0){
                  filter.manufacturers=[this.manufacturer];
                }
               
                axios({
                  method: 'Get',
                  responseType: 'json',
                  url: '{{url("/")}}/api/icommerce/v3/products/',
                  params: {
                    include: 'category,categories',
                    filter:filter,
                    take:9,
                    page:this.p_currence
                  }
                }).then(response=> {
                  vue_index_commerce.order_response(response);
                });
              },

              //obtener fabricantes
              getManufacturers(){
                   axios({
                  method: 'Get',
                  responseType: 'json',
                  url: "{{url('/')}}/api/icommerce/v3/manufacturers",
                }).then(response=> {
                  this.manufacturers=response.data.data;
                });
              },
              
              //obtener lista de deceos
              get_wishlist: function () {
                  if (this.user) {
                    axios({
                        method: 'get',
                        responseType: 'json',
                        url: Laravel.routes.wishlist.get+'?filter={' + this.user+'}'
                    }).then(response => {
                      this.products_wishlist = response.data.data;
                      $.each(this.products_wishlist, function (index, item) {
                          if ( vue_show_commerce.product.id==item.product_id) {
                              button = $('.btn-wishlist').prop( "disabled", false );
                                button.find("i").addClass('fa-heart').removeClass('fa-heart-o');
                          }
                      });
                    })
                  }
                },
                //agregar listade deceos
                addWishList: function (item) {
                    if (this.user) {
                         button = $('.btn-wishlist');
                        button.find("i").addClass('fa-spinner fa-spin').removeClass('fa-heart');
                        if (!this.check_wisht_list(item.id)) {
                            axios.post("{{url('/')}}"+"/api/icommerce/v3/wishlists", {
                                attributes:{
                                    user_id: this.user,
                                    product_id: item.id
                                }
                            }).then(response => {
                                this.get_wishlist();
                                 this.alerta("producto agregado a la lista", "success");
                                 button.find("i").addClass('fa-heart').removeClass('fa-spinner fa-spin');
                            })
                        } else {
                            button.find("i").addClass('fa-heart-o').removeClass('fa-spinner fa-spin');
                            this.alerta("Producto en la lista", "warning");
                        }
                    }
                    else {
                        this.alerta("Por Favor, Inicie Sesion", "warning");
                    }
                },

                /*check if exist product in wisthlist*/
                check_wisht_list: function (id) {
                    var response = false;
                    $.each(this.products_wishlist, function (index, item) {
                        if ( id==item.product_id) {
                            response = true; 
                        }
                    });
                    return response;
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
                },

              /*Order response v2*/
              order_response: function(response){

                /*productos*/
                this.articles=response.data.data;
                /*paginador*/
                this.p_currence = response.data.meta.page.currentPage;
                this.pages = response.data.meta.page.lastPage;
                this.r_pages.latest = response.data.meta.page.lastPage;
                this.totalArticles = response.data.meta.page.total;

              },
              /*Order response v2*/
              /*Limpiar los filtros y traer todos los productos de la categoria*/
              clearAll: function(id){
                this.order= {
                  by: 'created_at',
                  type: 'DESC'
                };
                this.price.from= 0;
                this.price.to= 999999;
                this.min_price= 0;
                this.max_price= 999999;
                this.min='{{ isset($_REQUEST['min']) ? $_REQUEST['min'] : ''}}';
                this.max='{{ isset($_REQUEST['max']) ? $_REQUEST['max'] : ''}}';
                this.v_max=false;
                this.v_min=false;
                this.category.id=id;
                this.category_seleccionada="";

                this.getProducts();
              },

              /*change paginate to limit*/
              change_page_limit: function (page, btn) {
                if (btn === 'first') {
                  this.r_pages.first = 1;
                  this.r_pages.latest = this.v_pages;
                }
                if (btn === 'last') {
                  this.r_pages.first = (this.pages - this.v_pages);
                  this.r_pages.latest = this.pages;
                }

                this.getProducts();
              },
              //cambiar pagina
              changePage(type,numberPage=0){
                if(type=="first"){
                  this.p_currence=1;
                }else if(type=="last"){
                  this.p_currence=this.r_pages.latest;
                }else if(type=="next"){
                  this.p_currence=this.p_currence+1;
                }else if(type=="back"){
                  if(this.p_currence>1)
                  this.p_currence=this.p_currence-1;
                  else
                  return false;
                }else if(type=="page"){
                  this.p_currence=numberPage;
                }
                this.getProducts();
              },

              /* configura la consulta por order by */
           order_by: function () {
              switch (this.order_check) {
                case 'all' :
                this.order.field = 'created_at';
                this.order.way = 'desc';
                this.order = this.order;
                break;
                case 'nameaz' :
                this.order.field = 'slug';
                this.order.way = 'asc';
                this.order = this.order;
                break;
                case 'nameza' :
                this.order.field = 'slug';
                this.order.way = 'desc';
                this.order = this.order;
                break;
                case 'lowerprice' :
                this.order.field = 'price';
                this.order.way = 'asc';
                this.order = this.order;
                break;
                case 'higherprice' :
                this.order.field = 'price';
                this.order.way = 'desc';
                this.order = this.order;
                break;
              }
              this.getProducts();
            },
              
         
            },
        });
    </script>
   
@stop