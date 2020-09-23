    {{--    suscribe--}}
    <div class="container-suscribe opacity-suscribe">
            @include('partials.subcription')
    </div>
    
    <!-- Footer -->
    <footer class="page-footer font-small ">

        <!-- Footer Links -->
        <div class="container text-center text-md-left text-white">

            <!-- Grid row -->
            <div class="row margins-footer">

                <!-- Grid column -->
                <div class="col-md-3 col-lg-4 col-xl-4 mx-auto mb-4 py-0 ">
                    <!-- Content -->
                    <h6 class="">Contacto</h6>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                    <p class="mb-0 text-warning">!Llámanos¡</p>
                    <p>3114554055 - 3112234137 </p>
                    <p class="mb-0 text-warning">!Escríbenos¡</p>
                    <p>info@pinturasrenovar.com</p>
                    <p class="mb-0 text-warning">!Visítanos¡</p>
                    <p>Carrera 6 # 9-66 Parque Santa Rita Facatativá</p>
                    <p class="mb-0 text-warning">Horario</p>
                    <p>7:00am - 6:pm</p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="">Pinturas Renovar</h6>
                    <br>
                        @menu('main')
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
{{--                    menu categorias-footer--}}
                    <h6 class="">Categorías</h6>
                    <br>
                        @menu('categorias-footer')
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
{{--                    menu apoyo-cliente-footer--}}
                    <h6 class="">Apoyo al Cliente</h6>
                    <br>
                        @menu('apoyo-cliente-footer')
                </div>
            </div>
        </div>
        {{--                social white networks--}}
        <div class="row">
            <div class="container">
                <div class="col-12 ml-md-auto  col-md-auto text-center text-md-right p-0">
                    @include('partials.social')
                </div>
            </div>
            </div>
        <br>
        <div class="bg-dark">
            <hr>
        </div>
        <!-- Copyright -->
            <div class="container copyright">
                <div class="row justify-content-between">
                    <div class="col-md-6 text-center flex-wrap text-md-left  d-flex align-items-center justify-content-center justify-content-md-start">
                            @include('partials.logoimagina')
                            <p class="m-0 ml-md-3">  Copyright © {{date("Y")}} Todos Los Derechos Reservados</p>
                    </div>
                    {{--            pay methods--}}
                    <div class="row col-md-6">
                            <img src="/themes/imagina2018/img/paymethods.png" class=" float-right img-fluid pb-3 pb-md-0" alt="payu" >
                    </div>
                </div>

            </div>
    </footer>


