<section >
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="title-arrow text-center mb-5">
                    <h2 class="">Nuevos Productos</h2>
                </div>

                <div id="featurednew">
                    <featurednew  @add-cart="addCart" :take="20"></featurednew>
                </div>
            </div>
        </div>
    </div>
</section>


@section('scripts-owl')
    @parent

    <script>
        const featurednew = new Vue({
            el: '#featurednew',
            data: {
                currency: false,
                products_new: [],
                user: false
            },
            methods: {
                /*agrega el producto al carro de compras*/
                addCart: function (item) {
                    vue_carting.addItemCart(item.id,item.name,item.price);
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
@stop
