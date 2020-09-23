
<script>
    var vue_function = new Vue({
        el: '#function',
        mounted: function () {
        this.$nextTick(function () {
            vue_function.get_wishlist();
        });
        },
        data: {
            user: {!! Auth::user() ? Auth::user()->id : 0 !!},
        },
        methods: {
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
              var user_id= vue_function.user;
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
              if (vue_function.user) {
                axios.get(vue_function.url+"/api/icommerce/v3/wishlists", {
                  attributes:{
                    user_id: vue_function.user
                  }
                  },{}).then(response => {
                    vue_function.products_wishlist = response.data.data;
                    $.each(vue_function.products_wishlist, function (index, item) {
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
              if (vue_function.user) {
                button = $('.btn-wishlist');
                button.find("i").addClass('fa-spinner fa-spin').removeClass('fa-heart');
                if (!vue_function.check_wisht_list(item.id)) {
                  axios.post(vue_function.url+"/api/icommerce/v3/wishlists", {
                    attributes:{
                      user_id: vue_function.user,
                      product_id: item.id
                    }
                  }).then(response => {
                    vue_function.get_wishlist();
                    vue_function.alerta("producto agregado a la lista", "success");
                    button.find("i").addClass('fa-heart').removeClass('fa-spinner fa-spin');
                  })
                } else {
                  button.find("i").addClass('fa-heart-o').removeClass('fa-spinner fa-spin');
                  vue_function.alerta("Producto en la lista", "warning");
                }
              }
              else {
                vue_function.alerta("Por Favor, Inicie Sesion", "warning");
              }
            },

            /*check if exist product in wisthlist*/
            check_wisht_list: function (id) {
              var response = false;
              $.each(vue_function.products_wishlist, function (index, item) {
                if ( id==item.product_id) {
                  response = true;
                }
              });
              return response;
            },
  }
});
  </script>