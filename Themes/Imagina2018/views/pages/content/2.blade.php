{{--<div class="home" data-icontenttype="page" data-icontentid="2">--}}
    <div class="page" data-icontenttype="page" data-icontentid="2">
        @component('partials.widgets.breadcrumb')
    
            @if(! empty($page->image->path))
                @slot('img', $page->image->path)
            @endif
            @slot('titulo', $page->title)
            @slot('descripcion', $page->body)

            <li class="breadcrumb-item active">{{$page->title}} </li>
        @endcomponent
        <section class="iblock general-block21 pt-5" data-blocksrc="general.block21">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 pb-5">
                        <div class="icontenteditable mb-2">
                            <h2>PINTURAS RENOVAR</h2>
                        </div>

                        <div class="icontenteditable summary text-justify">
                            <p>Somos una empresa colombiana dedicada a la producción y comercialización de las diferentes
                                líneas de pinturas como son: Arquitectónica, maderas, automotriz y especializadas.
                                Los mejores productos para la construcción y acabados, pinturas de alta calidad vinilos;
                                Tipo 1 “Premium Satín y Ultracover”, Tipo 2 “Revive” y Tipo 3 “cumbre”. Esmaltes sintéticos
                                “Renocolor” y anticorrosivos “Reprotec”, Pintura Trafico, Estucos plásticos “Ultramastick”,
                                carraplast y PVA, además de comercializar una variada gama de marcas reconocidas en el país,
                                como son Sherwin Williams, Pintuco, Tonner, Súper, Every, entre muchas otras. Pretendemos
                                consolidarnos en nuestra actividad en el mercado nacional como la empresa líder en producción,
                                calidad y precio, para transmitir a nuestros clientes los beneficios propios de este esfuerzo</p>
                            <br>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-lg-6 pb-5">
                                <div class="icontenteditable">
                                    <h3>Misión</h3>
                                </div>
                                <div class="icontenteditable summary text-justify">
                                    <p>
                                        Somos una empresa generadora de soluciones en el desarrollo de productos arquitectónicos e industriales, dispuesta a brindar
                                        a nuestros clientes la mejor calidad de productos para la construcción con énfasis en calidad, servicio de entrega a tiempo,
                                        y precio.
                                    </p>
                                    
                                    <p>
                                        Contamos con un gran equipo humano auto gestionado, con gran experiencia en el mercado y dispuesto a dar lo mejor para
                                        satisfacer las necesidades de nuestros clientes.
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 pb-5">
                                <div class="icontenteditable">
                                    <h3>Visión</h3>
                                </div>
                                <div class="icontenteditable summary text-justify">
                                    <p>
                                        En el año 2025 consolidar una empresa líder en Colombia en la producción y comercialización en el mercado de las Pinturas,
                                        recubrimientos arquitectónicos e industriales y todo lo relacionado con acabados para la construcción con los más altos
                                        estándares en calidad y cumpliendo de las normas internacionales, con un equipo humano empoderado y con las mejores prácticas
                                        de la industria nacional con un profundo respeto por el cliente, el entorno y el Medio Ambiente.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <section class="iblock general-block22 bg-light py-5" data-blocksrc="general.block22">
            <div class="container">
                <div class="row ">
                    <div class="col-12 py-5">
                        <div class="icontenteditable mb-4">
                            <h2>LOREM IPSOM</h2>
                        </div>
                        <div class="icontenteditable text-justify">
                            <ul>
                                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi aut consectetur, cumque
                                    doloribus, eligendi est ex excepturi fuga laboriosam mollitia nesciunt nulla repellendus
                                    sed sit suscipit totam veniam vitae. Delectus.
                                </li>
                                <li>fuga laboriosam mollitia nesciunt nulla repellendus
                                    sed sit suscipit totam veniam vitae. Delectus.
                                </li>
                                <li>fuga laboriosam mollitia nesciunt nulla repellendus
                                    sed sit suscipit totam veniam vitae. Delectus.
                                </li>
                                <li>fuga laboriosam mollitia nesciunt nulla repellendus
                                    sed sit suscipit totam veniam vitae. Delectus.
                                </li>
                                <li>Rfuga laboriosam mollitia nesciunt nulla repellendus
                                    sed sit suscipit totam veniam vitae. Delectus.
                                </li>
                            </ul>

                        </div>
                    </div>

                </div>
            </div>
        </section>
        <section class="iblock general-block23 py-5 margins-nosotros-page-2" data-blocksrc="general.block23">
            <div class="container">
                <div class="row ">
                    <div class="col-12">
                        <div class="icontenteditable text-center ">
                            <h2>LOREM REM RIMS SOME IFS</h2>
                        </div>

                        <div class="icontenteditable text-center mb-3">
                            <h3>PINTURAS RENOVAR</h3>
                        </div>

                        <div class="icontenteditable summary mb-4 text-justify">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam corporis, cumque, dolor doloribus
                                enim eum eveniet ex fuga ipsa modi, nulla perspiciatis porro quibusdam quo rerum sed tenetur veritatis
                                voluptas.</p>
                            <br>
                            <p>fuga laboriosam mollitia nesciunt nulla repellendus
                                sed sit suscipit totam veniam vitae. Delectus.</p>
                        </div>

                        <div class="icontenteditable text-justify">
                            <ul>
                                <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda deserunt dicta ducimus eveniet fugiat,
                                    illo, iste neque nesciunt nihil numquam officia perspiciatis quas quibusdam quo quod ratione, recusandae
                                    sed voluptate?
                                </li>
                                <li>fuga laboriosam mollitia nesciunt nulla repellendus
                                    sed sit suscipit totam veniam vitae. Delectus.
                                </li>
                                <li>fuga laboriosam mollitia nesciunt nulla repellendus
                                    sed sit suscipit totam veniam vitae. Delectus.
                                </li>
                                <li>fuga laboriosam mollitia nesciunt nulla repellendus
                                    sed sit suscipit totam veniam vitae. Delectus.
                                </li>
                                <li>fuga laboriosam mollitia nesciunt nulla repellendus
                                    sed sit suscipit totam veniam vitae. Delectus.</li>
                                <li>fuga laboriosam mollitia nesciunt nulla repellendus
                                    sed sit suscipit totam veniam vitae. Delectus.</li>
                                <li>Tfuga laboriosam mollitia nesciunt nulla repellendus
                                    sed sit suscipit totam veniam vitae. Delectus.
                                </li>
                            </ul>

                        </div>

                    </div>

                </div>
            </div>
        </section>

    </div>


    <div class="col-12 col-sm-8 pt-2 offset-sm-2">
{{--        {!! iform(1, 'iforms::frontend.form.bt-horizontal.form') !!}--}}
    </div>

{{--</div>--}}
















