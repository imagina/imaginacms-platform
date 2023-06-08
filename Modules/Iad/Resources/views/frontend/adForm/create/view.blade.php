@extends('layouts.master')

@section('content')

  <div id="content_form_ad" class="my-4 px-5">

    {{-- Publish banner --}}
    <div class="row my-4 py-4">
      <div class="col-md-12 col-sm-12 text-center">
        <div class="bg-primary text-center py-5  text-white">
          <h2>
            Publícate!
          </h2>
          <p>Hacer parte de Sexy Latinas es muy fácil, solo debes completar el formulario a continuación. No olvides
            llenarlo todo correctamente para que tu anuncio no sea descartado</p>
          <div class="content">
            <svg id="more-arrows">
              <polygon class="arrow-top" points="37.6,27.9 1.8,1.3 3.3,0 37.6,25.3 71.9,0 73.7,1.3 "/>
              <polygon class="arrow-middle" points="37.6,45.8 0.8,18.7 4.4,16.4 37.6,41.2 71.2,16.4 74.5,18.7 "/>
              <polygon class="arrow-bottom" points="37.6,64 0,36.1 5.1,32.8 37.6,56.8 70.4,32.8 75.5,36.1 "/>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <div class="row">

      <div class="col-md-6">
        <div class="pr-3">
          <h3 class="font-weight-bold my-1">¿Dónde quieres anunciarte?</h3>
          {{--
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label text-sm-right pr-md-0 font-weight-bold">Categoría</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="category_id" v-model="form.category_id">
                          <option value="">Selecciona una categoría</option>
                          @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->title}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    --}}

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-sm-right pr-md-0 font-weight-bold">Ubicación</label>
            <div class="col-sm-10">
              <input type="text" placeholder="Encuentra tu ciudad o barrio" class="form-control" name="fields[address]"
                     required v-model="fields.address">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-sm-right pr-md-0 font-weight-bold">Departamento</label>
            <div class="col-sm-10">
              <select class="form-control" name="province_id" v-model="form.province_id" @change="getCities()" required>
                <option value="">Seleccione un departamento</option>
                <option v-for="province in provinces" :value="province.id">@{{province.name}}</option>
              </select>
            </div>
          </div>

          <div class="form-group row" v-if="cities.length>0">
            <label class="col-sm-2 col-form-label text-sm-right pr-md-0 font-weight-bold">Ciudad</label>
            <div class="col-sm-10">
              <select class="form-control" name="city_id" v-model="form.city_id" @change="getNeighborhoods()" required>
                <option value="">Seleccione una ciudad</option>
                <option v-for="city in cities" :value="city.id">@{{city.name}}</option>
              </select>
            </div>
          </div>

          <div class="form-group row" v-if="neighborhoods.length>0">
            <label class="col-sm-2 col-form-label text-sm-right pr-md-0 font-weight-bold">Barrio</label>
            <div class="col-sm-10">
              <select class="form-control" name="neighborhood_id" v-model="form.neighborhood_id" required>
                <option value="">Seleccione un barrio</option>
                <option v-for="neighborhood in neighborhoods" :value="neighborhood.id">@{{neighborhood.name}}</option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-sm-right pr-md-0 font-weight-bold">Teléfono</label>
            <div class="col-sm-10">
              <input type="text" placeholder="Escribe claramente tu número de contacto" class="form-control"
                     name="fields[phone]" required v-model="fields.phone">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-sm-right pr-md-0 font-weight-bold">Nota Adicional</label>
            <div class="col-sm-10">
              <textarea placeholder="Escribe datos adicionales que consideres relevantes.." class="form-control"
                        v-model="fields.note" rows="4" cols="80" style="max-width:100%;height:150px;"></textarea>
            </div>
          </div>

        </div>
      </div>

      <div class="col-md-6 text-left">
        <div class="pr-3">
          <h3 class="font-weight-bold my-1">Datos del anuncio</h3>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-sm-right pr-md-0 font-weight-bold">Título</label>
            <div class="col-sm-10">
              <input placeholder="Escoge un título llamativo para tu anuncio" type="text" class="form-control"
                     name="title" required v-model="form.title">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-sm-right pr-md-0 font-weight-bold">Descripción del
              anuncio</label>
            <div class="col-sm-10">
              <textarea placeholder="Exprésate y describe tus servicios a tus clientes.." class="form-control"
                        name="description" v-model="form.description" rows="4" cols="80"
                        style="max-width:100%;height:150px;"></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-sm-right pr-md-0 font-weight-bold">Nombre</label>
            <div class="col-sm-10">
              <input placeholder="..." type="text" class="form-control" name="fields[name]" required
                     v-model="fields.name">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-sm-right pr-md-0 font-weight-bold">Edad</label>
            <div class="col-sm-10">
              <select class="form-control" required name="fields[age]" v-model="fields.age">
                @for($i=18;$i<=60;$i++)
                  <option value="{{$i}}">{{$i}}</option>
                @endfor
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-sm-right pr-md-0 font-weight-bold">Twitter</label>
            <div class="col-sm-10">
              <input placeholder="..." type="text" class="form-control" name="fields[twitter]" required
                     v-model="fields.twitter">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label text-sm-right pr-md-0 font-weight-bold">WhatsApp</label>
            <div class="col-sm-10">
              <input placeholder="(+57)" type="text" class="form-control" name="fields[whatsapp]" required
                     v-model="fields.whatsapp">
            </div>
          </div>

          <div class="form-group row">
            <label class="text-sm-right pr-md-0 font-weight-bold">¿Eres una escort independiente?</label>
            <br>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="field[independent_escort]"
                     v-model="fields.independent_escort"
                     id="independent_escort">
              <label class="form-check-label" for="independent_escort">
                Sí, este teléfono es exclusivamente
                mío y respondo yo a los clientes directamente cuando estos llaman.
              </label>
            </div>
          </div>

        </div>
      </div>


      <!-- Tarifas -->
      <div class="col-lg-12">

        <div class="card-collapse border-0">
          <div class="card-header">
            <h5 class="mb-0">
              <a class="d-flex justify-content-between align-items-center" data-toggle="collapse"
                 data-target="#collapse" aria-expanded="false"
                 aria-controls="collapse">
                Tarifas
                <i class="fa fa-chevron-circle-right float-right" aria-hidden="true"></i>
              </a>
            </h5>
          </div>
          <div id="collapse" class="collapse border-0">
            <div class="card-body row">

              <div class="col-lg-4">
                <label class="text-sm-right pr-md-0 font-weight-bold">Descripción</label>
              </div>

              <div class="col-lg-3">
                <label class="text-sm-right pr-md-0 font-weight-bold">Precio pesos</label>
              </div>

              <div class="col-lg-5 text-center">
                <button type="button" name="button" @click="form.rates.push({rate_id:'',price:''})"
                        class="btn btn-primary">Agregar
                </button>
              </div>

              <div class="col-lg-12">
                <div class="row my-2" v-for="rateAd in form.rates">
                  <div class="col-lg-4">
                    <select class="form-control" v-model="rateAd.rate_id">
                      <option value="">Seleccione una tarifa</option>
                      <option :value="rate.value" v-for="rate in rates">@{{rate.label}}</option>
                    </select>
                  </div>
                  <div class="col-lg-3">
                    <input type="number" step="0.1" class="form-control" v-model="rateAd.price">
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
      <!-- Tarifas -->

      <!-- Horario s-->
      <div class="col-lg-12">

        <div class="card-collapse border-0">
          <div class="card-header">
            <h5 class="mb-0">
              <a class="d-flex justify-content-between align-items-center" data-toggle="collapse"
                 data-target="#collapse2" aria-expanded="false"
                 aria-controls="collapse2">
                Horarios
                <i class="fa fa-chevron-circle-right float-right" aria-hidden="true"></i>
              </a>
            </h5>
          </div>
          <!-- Div collapse -->
          <div id="collapse2" class="collapse border-0">
            <div class="card-body row">

              <div class="col-md-12" v-if="form.options.sameSchedule==1">
                <!-- Select one schedule -->

              </div>

              <div class="col-md-12" v-else>
                <!-- Show all schedules -->
              </div>

            </div>
          </div>
          <!-- Div collapse -->
        </div>

      </div>
      <!-- Horarios -->

      <!-- Fotos-->

      <div class="col-lg-12">

        <div class="card-collapse border-0">
          <div class="card-header">
            <h5 class="mb-0">
              <a class="d-flex justify-content-between align-items-center" data-toggle="collapse"
                 data-target="#collapse3" aria-expanded="false"
                 aria-controls="collapse3">
                Imagen Principal
                <i class="fa fa-chevron-circle-right float-right" aria-hidden="true"></i>
              </a>
            </h5>
          </div>
          <!-- Div collapse -->
          <div id="collapse3" class="collapse border-0">
            <div class="card-body text-center">
              <image-uploader
                :debug="1"
                :maxHeight="200"
                :maxWidth="200"
                :quality="0.7"
                :autoRotate=true
                outputFormat="verbose"
                :preview=true
                :className="['fileinput', { 'fileinput--loaded' : hasImage }]"
                capture="environment"
                accept="image/*"
                doNotResize="['gif', 'svg']"
                @input="setImage"
                @onUpload="startImageResize"
                @onComplete="endImageResize"
              ></image-uploader>
            </div>
          </div>
          <!-- Div collapse -->
        </div>

      </div>

      <div class="col-lg-12">

        <div class="card-collapse border-0">
          <div class="card-header">
            <h5 class="mb-0">
              <a class="d-flex justify-content-between align-items-center" data-toggle="collapse"
                 data-target="#collapse4" aria-expanded="false"
                 aria-controls="collapse4">
                Galería de fotos
                <i class="fa fa-chevron-circle-right float-right" aria-hidden="true"></i>
              </a>
            </h5>
          </div>
          <!-- Div collapse -->
          <div id="collapse4" class="collapse border-0">

          </div> <!-- Div collapse -->

        </div>

      </div>

      <!-- Fotos -->

      <!-- Vídeos-->

      <div class="col-lg-12">

        <div class="card-collapse border-0">
          <div class="card-header">
            <h5 class="mb-0">
              <a class="d-flex justify-content-between align-items-center" data-toggle="collapse"
                 data-target="#collapse5" aria-expanded="false"
                 aria-controls="collapse5">
                Vídeos
                <i class="fa fa-chevron-circle-right float-right" aria-hidden="true"></i>
              </a>
            </h5>
          </div>
          <!-- Div collapse -->
          <div id="collapse5" class="collapse border-0">
            <!-- Component to upload videos -->
            <p>Los vídeos son validados antes de ser publicados y pueden tardar hasta 24 horas laborales en aparecer en
              el anuncio.</p>
          </div> <!-- Div collapse -->

        </div>

      </div>

      <!-- Vídeos -->

      <!-- Sobre tí-->

      @foreach($categories as $category)
        {{--        @php($category = str_replace(" " , "", $category))--}}
        <div class="col-lg-12">

          <div class="card-collapse border-0">
            <div class="card-header">
              <h5 class="mb-0">
                <a class="d-flex justify-content-between align-items-center {{$category->slug}}" data-toggle="collapse"
                   data-target="#collapseCategory{{$category->id}}" aria-expanded="false"
                   aria-controls="collapseCategory{{$category->id}}">
                  {{$category->title}}
                  <i class="fa fa-chevron-circle-right float-right" aria-hidden="true"></i>
                </a>
              </h5>
            </div>
          @foreach($category->children as $children)
            <!-- Div collapse -->
              <label id="collapseCategory{{$category->id}}" class="card-header collapse border-0 p-1 m-2">
                 <span class="mx-2">
                   <input type="checkbox" name="tags" v-model="tagsMe">
                   {{$children->title}}
                 </span>
              </label>
          @endforeach
          </div>

        </div>
{{--        <div>childen category {{  tagsMe }}</div>--}}
    @endforeach



    <!-- Mapa-->

      <div class="col-lg-12">

        <div class="card-collapse border-0">
          <div class="card-header">
            <h5 class="mb-0">
              <a class="d-flex justify-content-between align-items-center" data-toggle="collapse"
                 data-target="#collapse10" aria-expanded="false"
                 aria-controls="collapse10">
                Mapa
                <i class="fa fa-chevron-circle-right float-right" aria-hidden="true"></i>
              </a>
            </h5>
          </div>
          <!-- Div collapse -->
          <div id="collapse10" class="collapse border-0 py-2">
            <div class="card-body">
              <p>Para facilitar que tus clientes encuentran tu departamento o local puedes
                <span style="color:red;">mostrar en tu anuncio un mapa</span> con tu ubicación.
              </p>
              <p>
                Ejemplos:Gran Vía con Calle San Bernardo, Calle de Goya 125, Avenida de Francia 34, etc.
              </p>

              <div>
                <!-- this is an example of reverse geocoding an address and obtaining
            Lat and long data, it includes TypeAhead suggestions, try it out by typing into the
            Adress field below -->

                <div class="container_fluid">
                  <input id="address" v-model="address" class="form-control input-md"
                         placeholder="Selecciona una población"
                         value="">
                  <div id="map_canvas" style="width:100%; height:300px"></div>
                  <br>
                  <div class="row">
                    <div class="col-md-3">
                      <input id="latitude" v-model="lattitude" type="hidden"
                             value="">
                    </div>
                    <div class="col-md-3">
                      <input id="longitude" v-model="longitude" type="hidden"
                             value="">
                    </div>
                  </div>
                </div>

                <div class="container">
                  <input
                    type="hidden"
                    id="addresshidd"
                    v-model="form.options.address"
                  >
                </div>
              </div>


            </div>
          </div> <!-- Div collapse -->

        </div>

      </div>

      <!-- Mapa -->

      <!-- Experiencia de mis clientes-->

      <div class="col-lg-12">

        <div class="card-collapse border-0">
          <div class="card-header">
            <h5 class="mb-0">
              <a class="d-flex justify-content-between align-items-center" data-toggle="collapse"
                 data-target="#collapse11" aria-expanded="false"
                 aria-controls="collapse11">
                Experiencia de mis clientes
                <i class="fa fa-chevron-circle-right float-right" aria-hidden="true"></i>
              </a>
            </h5>
          </div>
          <!-- Div collapse -->
          <div id="collapse11" class="collapse border-0 py-2">
            <div class="card-body">
              <p>Si tienes experiencias o reseñas publicadas por catadores en foros de prepagos como:
                <b>ForoPrepagosColombia, DonColombia, etc.</b> y quieres que las enlacemos desde tu
                anuncio, indica las direcciones web a continución separadas por coma:
              </p>
              <input type="text" class="form-control" v-model="fields.customer_feedback" placeholder="https://">
            </div>
          </div> <!-- Div collapse -->

        </div>

      </div>

      <!-- Experiencia de mis clientes -->

      <div class="col-md-12 text-center">
        <button type="button" class="btn btn-primary" @click="saveAd()" name="button">Publicar mi anuncio</button>
      </div>

    </div>
  </div>

@stop


{{-- VUEJS SCRIPTS--}}
@includeFirst(['iad.adForm.create.scripts','iad::frontend.adForm.create.scripts'])
