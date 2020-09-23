@include('icommerce.partials.variables')

<span id="content_carting" class="d-inline-block">
    <!-- BUTTOM -->
    <a class="dropdown-toggle shopping-cart pr-0"
    id="dropdownCart"
    data-toggle="dropdown"
    aria-haspopup="true"
    aria-expanded="false" class="carting-enlace">   <i class="fa fa-shopping-cart"></i><small class="" >(@{{ quantity }})</small>
      
  
  
  </a>
  
  <!--Shopping cart-->
  <div class="nav-item cart-dropdown-menu" aria-labelledby="dropdownCart" style="z-index: 99999;">
    <!--Shopping cart dropdown -->
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownCart" style="  min-width: 20rem; z-index: 9999999">
      <!-- titulo -->
      <h4 class="dropdown-header mb-0 font-weight-bold text-center" v-if="articles.length>0">
        {{trans('icommerce::cart.articles.cart')}} (@{{articles.length}})
        <i class="fa fa-trash text-muted float-right" title="Vaciar carrito" v-on:click="clear_cart()"></i>
      </h4>
      <h5 class="dropdown-header mb-0 font-weight-bold text-center" v-else>
        {{trans('icommerce::cart.articles.empty_cart')}}
      </h5>
  
      <!-- articulos en el carrito -->
      <div class="item_carting px-3 w-100 row m-0" v-for="(item,indexArt) in articles.slice(0, 4)" v-if="articles.length>0">
        <hr class="mt-0 mb-3 w-100">
  
        <!-- imagen -->
        <div class="col-4 px-0">
          <div style="height: 80px; width: 100%; background-size:cover;" class="img_product_carting mr-3 border" v-bind:style="{ backgroundImage: 'url('+item.mainImage.path+')'}" v-on:click="location(item.slug)" style="cursor: pointer;">
          </div>
        </div>
        <!-- descripción -->
        <div class="col-8">
  
            <!-- titulo -->
            <h6 class="mb-2 w-100 __title">
              <a v-bind:href="item.url">
                @{{ item.name }} <label v-if="item.productOptionValues.length>0">(@{{(item.productOptionValues[0].optionValue)}})</label>
              </a>
            </h6>
            <!-- valor y cantidad -->
            <p class="mb-0 text-muted pb-2" style="font-size: 14px">
              {{trans('icommerce::cart.table.quantity')}}: @{{ item.quantity }} <br>
              {{trans('icommerce::cart.table.price_per_unit')}}: @{{ item.priceUnit |numberFormat }}
            </p>
  
          <!-- boton para eliminar-->
          <div style="width: 20px;  position: absolute; right: 0; top: 0;">
            <a class="close cart-remove text-danger"v-on:click="delete_item(item.id)" title="quitar producto">
              <i class="fa fa-times"></i>
            </a>
          </div>
        </div>
  
  
      </div>
  
      <!-- FOOTER CARTING -->
      <div class="dropdown-footer text-center" v-if="articles">
        <hr class="mt-3 mb-3">
        <!-- total -->
        <h6 class="font-weight-bold">
          {{trans('icommerce::cart.table.total')}}
          <span class="text-primary">
            @{{  total | numberFormat}}
          </span>
        </h6>
        <!-- botones-->
        <a href="{{ url('/checkout') }}" tabindex="-1" class="btn btn-primary mx-1 text-white">
          {{trans('icommerce::cart.button.view_cart')}}
        </a>
  
  
  
      </div>
    </div>
  </div>
  </span>
  <div id="function"></div>
  
  @section('scripts-owl')
  
  <script >
  var vue_carting = new Vue({
  
    el: '#content_carting',
    mounted: function () {
      this.$nextTick(function () {
        this.getCart();
      });
    },
    data: {
      articles: [],
      user: {!! Auth::user() ? Auth::user()->id : 0 !!},
      total: 0,
      cart:null,
      quantity: 0,
      currencySymbolLeft: icommerce.currencySymbolLeft,
      currencySymbolRight: icommerce.currencySymbolRight,
    },
       filters: {
              numberFormat: function (value) {
          if (value != '')
            return vue_carting.currencySymbolLeft + " " + (parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1.').slice(0,-3)) + " " + vue_carting.currencySymbolRight;
          else
            return value;
        }
            },
    methods: {
      getCart(){
        var cart_id=localStorage.getItem("cart_id");
        if(cart_id){
          axios.get("{{url('/')}}"+"/api/icommerce/v3/carts/"+cart_id)
          .then(function (response) {
            vue_carting.cart=response.data.data;
            vue_carting.articles=vue_carting.cart.products;
            vue_carting.quantity=vue_carting.cart.quantity;
            vue_carting.total=vue_carting.cart.total;
            if(!vue_carting.quantity)
            vue_carting.quantity=0;
            if(!vue_carting.total)
            vue_carting.total=0;
          })
          .catch(function (error) {
            localStorage.clear();
          });
        }else{
          this.createCart();
        }
      },
      createCart(){
        var id=0;
        axios.post("{{url('/')}}"+"/api/icommerce/v3/carts", {
          attributes:{
            total:0
          }
        }).then(response=> {
          id=response.data.data.id;
          localStorage.setItem("cart_id", id);
          this.getCart();
        })
        .catch(function (error) {
          console.log(error);
        });
        return id;
      },
      clear_cart() {
        if(this.articles.length>0){
          for(var i=0;i<this.articles.length;i++){
            axios.delete("{{url('/')}}"+"/api/icommerce/v3/cart-products/"+this.articles[i].id)
            .then(response=>{
              console.log(response.data);
            }).catch(function (error) {
              console.log(error);
            });
          }//for articles
          this.getCart();
          toastr.success(" {{trans('icommerce::cart.message.delete')}}");
        }//if articles length >0
      },
      addItemCart(productId,productName,price,quantity=1,productOptValue=[]){
        var cart_id=localStorage.getItem("cart_id");
        if(!cart_id){
          vue_carting.createCart();
          cart_id=localStorage.getItem("cart_id");
        }
        axios.post("{{url('/')}}"+"/api/icommerce/v3/cart-products", {
          attributes:{
            cart_id:cart_id,
            product_id:productId,
            product_name:productName,
            price:price,
            quantity:quantity,
            product_option_values:productOptValue
          }
        })
        .then(function (response) {
          toastr.success(" {{trans('icommerce::cart.message.add')}}")
          vue_carting.getCart();
          return true;
        })
        .catch(function (error) {
          console.log(error);
        });
        return false;
      },
      delete_item(item_id){
        axios.delete("{{url('/')}}"+"/api/icommerce/v3/cart-products/"+item_id)
        .then(response=>{
          this.getCart();
          return true;
        }).catch(function (error) {
          console.log(error);
        });
        return false;
      },
  
  
      location: function(url){
        window.location = url;
      },
      addRating(star, product){
            var user_id= {!! Auth::user() ? Auth::user()->id : 0 !!};
              if(user_id<=0){
                toastr.error('Debes estar autenticado');
                alert('Debes estar autenticado');
              }else{
                var token="Bearer "+"{!! Auth::user() ? Auth::user()->createToken('Laravel Password Grant Client')->accessToken : "0" !!}";
                axios.post("{{url('/')}}"+"/api/icommerce/v3/products/rating", {
                  attributes:{
                    star: star,
                    product_id: product.id
                  }
                },{
                  headers:{
                    'Authorization':token
                  }
                }).then(response => {
                  toastr.success("Rating actualizado.");
                }).catch(function (error) {
                  var errors=error.response.data;
                  toastr.error(errors.errors);
                  alert(errors.errors);
                });
              }//else

            },
            addRating(product){
              var user_id= vue_carting.user;
              if(user_id<=0){
                toastr.error('Debes estar autenticado');
              }else{
                var token="Bearer "+"{!! Auth::user() ? Auth::user()->createToken('Laravel Password Grant Client')->accessToken : "0" !!}";
                var star=product.rating +1;
                if(star<=5){
                   axios.post("{{url('/')}}"+"/api/icommerce/v3/products/rating", {
                  attributes:{
                    star: star,
                    product_id: product.id
                  }
                  },{
                    headers:{
                      'Authorization':token
                    }
                  }).then(response => {
                     toastr.success("Rating actualizado.");
                    
                  }).catch(function (error) {
                    var errors=error.response.data;
                    toastr.error(errors.errors);
                  });
               }
              }//else

            },
            /* products wishlist */
            get_wishlist: function () {
              if (vue_carting.user) {
                axios.get("{{url('/')}}/api/icommerce/v3/wishlists/"+vue_carting.user).then(response => {
                    vue_carting.products_wishlist = response.data.data;
                    $.each(vue_carting.products_wishlist, function (index, item) {
                        if ( vue_show_commerce.product.id==item.product_id) {
                        button = $('.btn-wishlist').prop( "disabled", false );
                        button.find("i").addClass('fa-heart').removeClass('fa-heart-o');
                        }
                    });
                  }).catch(function (error) {
                    var errors=error.response.data;
                    toastr.error(errors.errors);
                  });                  

              }
            },


            /* product add wishlist */
            addWishList: function (item) {
                console.log(vue_carting.user);
              if (vue_carting.user) {
                button = $('.btn-wishlist');
                button.find("i").addClass('fa-spinner fa-spin').removeClass('fa-heart');
                if (!vue_carting.check_wisht_list(item.id)) {
                  axios.post("{{url('/')}}/api/icommerce/v3/wishlists", {
                    attributes:{
                      user_id: vue_carting.user,
                      product_id: item.id
                    }
                  }).then(response => {
                    vue_carting.alerta("producto agregado a la lista", "success");
                    button.find("i").addClass('fa-heart').removeClass('fa-spinner fa-spin');
                  })
                } else {
                  button.find("i").addClass('fa-heart-o').removeClass('fa-spinner fa-spin');
                  vue_carting.alerta("Producto en la lista", "warning");
                }
              }
              else {
                vue_carting.alerta("Por Favor, Inicie Sesion", "warning");
              }
            },

            /*check if exist product in wisthlist*/
            check_wisht_list: function (id) {
              var response = false;
              $.each(vue_carting.products_wishlist, function (index, item) {
                if ( id==item.product_id) {
                  response = true;
                }
              });
              return response;
            },
    }
  });
  
  
  </script>
  
  @parent
  @stop
  