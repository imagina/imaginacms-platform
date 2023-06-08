<div class="container modal-pin">
  <div class="row">
    <div class="col-lg-6 pb-4">
      <x-media::gallery id="pinGallery" :mediaFiles="$item->mediaFiles()" :zones="['mainimage','gallery']"
                        layout="gallery-layout-4" :dots="false"/>

      @if(count($item->mediaFiles()->videos)>0)
        <h3 class="modal-title my-3">
          Videos
        </h3>
        <x-media::gallery :mediaFiles="$item->mediaFiles()" :zones="['videos']" layout="gallery-layout-2"
                          :columnMasonry="3"/>
      @endif
    </div>
    <div class="col-lg-6 pb-4">
      <h2 class="modal-title mb-3">
        <a href="{{$item->url}}">{{$item->title}} </a>
        <br>
        @if(isset($item->fields->where('name','name')->first()->value))
          {{$item->fields->where('name','name')->first()->value}}
        @endif
      </h2>
      @if(isset($item->city->name))
        <span class="badge info-badge">
          {{--Ciudad--}}
          <i class="fa fa-map-marker"></i>
          {{$item->city->name}}
        </span>
      @endif
      @if(isset($item->locality->name))
        <span class="badge info-badge">
          {{--Localidad--}}
          <i class="fa fa-map-marker"></i>
          {{$item->locality->name}}
        </span>
      @endif
      @if(isset($item->neighborhood->name))
        <span class="badge info-badge">
          {{--Barrio--}}
          <i class="fa fa-thumb-tack"></i>
          {{$item->neighborhood->name}}
        </span>
      @endif
      @if(isset(collect($item->fields)->where('name','age')->first()->value))
        <span class="badge info-badge">
          {{--21 años--}}
          {{collect($item->fields)->where('name','age')->first()->value}} años
        </span>
      @endif
      @if(!empty($item->defaultPrice))
        <span class="badge info-badge">${{formatMoney($item->defaultPrice)}}</span>
      @endif
      <span class="badge info-badge">{{$item->country->name}}</span>
      @if($item->status == 3)
        <span class="badge info-badge certified" title="{{trans("iad::status.checked")}}"></span>
      @endif
      @if(count($item->mediaFiles()->videos)>0)
        <span class="badge info-badge videos">
          <i class="fa fa-play-circle-o" aria-hidden="true"></i>
          {{count($item->mediaFiles()->videos)}}</span>
      @endif
      @php($gallery = $item->mediaFiles()->gallery)
      @if(count($gallery)>0)
        <span class="badge info-badge photos">
          <i class="fa fa-camera" aria-hidden="true"></i>
          {{count($gallery)}}</span>
      @endif
      @if($item->checked)
        <span class="badge info-badge videos">
          <a class="link-verified" data-toggle="tooltip" title="{{trans('iad::ads.verifiedAd')}}">
            <i class="fa fa-check-square text-white"></i>
          </a>
          {{trans('iad::ads.verifiedAd')}}</span>
      @endif
      @if(setting('iad::dateInShow'))
        <p class="modal-date my-3">
          {{date("d/m/Y H:ia",strtotime($item->created_at))}}
        </p>
      @endif
      <div class="modal-description">
        {!! nl2br ($item->description) !!}
        {!! $item->options->secondaryDescription ?? "" !!}
      </div>
      <div class="group-btn">
        @if(isset($item->options->whatsapp))
          <a class="btn btn-whatsapp"
             href="https://wa.me/+57{{ $item->options->whatsapp }}?text={!! setting('iad::whatsappTextAnuncio') !!}"
             target="_blank">
            <i class="fa fa-whatsapp"> </i> WhatsApp
          </a>
        @endif
        @if(isset($item->options->facebook))
          <a class="btn btn-facebook" href="https://www.facebook.com/{{ $item->options->facebook }}" target="_blank">
            <i class="fa fa-facebook"> </i> Facebook
          </a>
        @endif
        @if(isset($item->options->instagram))
          <a class="btn btn-instagram" href="https://instagram.com/{{$item->options->instagram}}" target="_blank">
            <i class="fa fa-instagram"> </i> Instagram
          </a>
        @endif
        @if(isset($item->options->twitter))
          <a class="btn btn-twitter"
             href="https://twitter.com/{{$item->options->twitter}}" target="_blank">
            <i class="fa fa-twitter"> </i>Twitter
          </a>
        @endif
        @if(isset($item->options->youtube))
          <a class="btn btn-youtube"
             href="https://youtube.com/{{$item->options->youtube}}" target="_blank">
            <i class="fa fa-youtube"></i>Youtube
          </a>
        @endif
        @if(isset($item->options->urlPage))
          <a class="btn btn-web"
             href="{{$item->options->urlPage}}" target="_blank">
            <i class="fa fa-globe"></i>Pagina Web
          </a>
        @endif
        @if(isset($item->options->phone))
          <a class="btn btn-phone" href="tel:{{$item->options->phone}}"
             target="_blank">
            <i class="fa fa-mobile"></i> {{$item->options->phone}}
          </a>
        @endif
        <a class="btn btn-like"
           onClick="window.livewire.emit('addToWishList',{{json_encode(["entityName" => "Modules\\Iad\\Entities\\Ad", "entityId" => $item->id])}})">
          <i class="fa fa-heart"></i>
        </a>
      </div>
    </div>
  </div>
  @if(isset($item->options->prices) && !empty($item->options->prices) || isset($item->options->schedule) && !empty($item->options->schedule))
    <div class="row">
      <!--Rates-->
      @if(isset($item->options->prices) && !empty($item->options->prices))
        <div class="col-lg-6 pb-4">
          <h3 class="modal-title mb-3">
            Tarifas
          </h3>
          @foreach($item->options->prices ?? [] as $rate)
            <div class="row align-items-center modal-item">
              <div class="col-5 col-sm-3">{{$rate->description}}</div>
              <div class="col-5 col-sm-4 text-primary">${{formatMoney($rate->value)}}</div>
            </div>
          @endforeach
        </div>
      @endif
      <!--Schedule-->
      @if(isset($item->options->schedule) && isset($item->options->statusSchedule) && $item->options->statusSchedule)
        <div class="col-lg-6 pb-4">
          <h3 class="modal-title mb-3">
            Horarios
          </h3>
          @foreach($item->options->schedule ?? [] as $schedule)
            <div class="row align-items-center modal-item">
              <div class="col-5 col-sm-4">
                {{trans("iad::schedules.days.".$schedule->name)}}
              </div>
              <div class="col-5 col-sm-4 text-primary">
                @if($schedule->schedules == 1)
                  {{trans("iad::schedules.schedules.24Hours")}}
                @elseif($schedule->schedules == 0)
                  {{trans("iad::schedules.schedules.closed")}}
                @else
                  @foreach($schedule->schedules ?? [] as $shift)
                    {{date("g:ia",strtotime($shift->from))}} -
                    {{date("g:ia",strtotime($shift->to))}}
                  @endforeach
                @endif
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  @endif
  @php($categories = Modules\Iad\Entities\Category::all())
  @php($categories = $categories->toTree())
  @if(!empty($item->categories))
    <div class="row">
      @foreach($categories ?? [] as $categoryParent)
        @php($categoriesAd = array_intersect($item->categories->pluck("id")->toArray(),$categoryParent->children->pluck("id")->toArray()))
        @if(!empty($categoriesAd))
          <div class="col-12 col-md-4 pb-4">
            <h3 class="modal-title mb-3">
              {{$categoryParent->title}}
            </h3>
            @foreach($categoriesAd ?? [] as $categoryId)
              @php($categoryAd = $item->categories->where("id",$categoryId)->first())
              <span class="badge info-badge">
              <a href="{{url("?filter[categories][0]=$categoryId")}}">{{$categoryAd->title}}</a>
              </span>
            @endforeach
          </div>
        @endif
      @endforeach
    </div>
  @endif
  @if(!empty($item->options) && !empty($item->options->map))
    @if(!empty($item->options->map->lat) && !empty($item->options->map->lng))
      <div class="row">

        {{--Component Doesn't work to map - Reported --}}
        {{--
        <x-isite::Maps :lat="$item->options->map->lat" :lng="$item->options->map->lng" locationName="{{$item->title}}" zoom="16"/>
        --}}

        <iframe class="iframe-modal-iad"
                src="https://maps.google.com/?ll={{$item->options->map->lat}},{{$item->options->map->lng}}&z=16&t=m&output=embed"
                frameborder="0" height="400" style="width: 100%;" allowfullscreen></iframe>

      </div>
    @endif
  @endif

  <div class="featured-pins">

    <x-isite::carousel.owl-carousel
            title="Anuncios Destacados"
            id="featuredPins{{$item->id}}"
            loop=true
            autoplay=true
            autoplayTimeout=4000
            margin=10
            :nav=false
            :responsive="[0 => ['items' =>  1],640 => ['items' => 2],992 => ['items' => 4]]"
            repository="Modules\Iad\Repositories\AdRepository"
            itemComponent="iad::list-item"
            moduleName="Iad"
            itemComponentName="iad::list-item"
            itemComponentNamespace="Modules\Iad\View\Components\ListItem"
            :itemComponentAttributes="['embedded' => false]"
            entityName="Ad"
            :showTitle="false"
            :params="[
                        'include' => ['city','schedule','fields','categories','translations'],
                        'filter' =>[ 'status' => [2,3], 'featured' => true, 'order' => ['field' => 'uploaded_at', 'way' => 'desc'] ],
                        'take' => setting('isite::items-per-page',null,20)]"
            :responsiveTopContent="['mobile'=>false,'desktop'=>false]"
            :uniqueItemListRendered="false"
    />

  </div>
  <div id="report" class="row justify-content-center">
    <div class="col-auto">
      <a class="btn btn-danger"
         {{isset($inModal) && $inModal ? 'onclick=Iad__goToReport(event,\''.$item->url."#report".'\')' : 'data-toggle=collapse aria-expanded=false aria-controls=collapsePin'.$item->id}} href="{{isset($inModal) && $inModal ? $item->url."#report" : "#collapsePin".$item->id}}"
         role="button">
        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
        {{trans('iad::common.report')}}
      </a>
    </div>
    <div class="col-12">
      <div class="collapse mt-4" id="collapsePin{{$item->id}}">
        <div class="card card-body pt-4 bg-light">

          <x-iforms::form :id="setting('iad::complaintForm')"
                          :fieldsParams="['adName' => ['readonly' => 'readonly' , 'value' => $item->title]]"/>
          {{--          {!! Forms::render(,'iforms::frontend.form.bt-nolabel.form') !!}--}}

          <p class="text-justify mt-4 mb-0"><strong>Nota:</strong> Si el motivo de la denuncia es que eres la
            persona que aparece en las fotos y quieres eliminar el anuncio, y no tienes acceso ni al email que
            se usó para publicarlo ni al teléfono que aparece en el anuncio, debes indicarnos un teléfono y
            email para que podamos contactar contigo y confirmar que realmente eres tú.</p>
        </div>
      </div>
    </div>
  </div>
</div>


<script>

  function Iad__goToReport(event, url) {
    event.preventDefault();
    console.warn("url", url)
    window.location.href = url
    window.location.reload(true)
  }


  $(document).ready(function () {


    $('.owl-image-mini{{$item->id}}').owlCarousel({
      responsiveClass: true,
      nav: false,
      video: true,
      margin: 10,
      dots: false,
      lazyContent: true,
      autoplay: true,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 4
        },
        768: {
          items: 4
        },
        992: {
          items: 4
        }
      }
    });


  });
  $(document).ready(function () {

    $('#featuredPins{{$item->id}}Carousel').owlCarousel({
      responsiveClass: true,
      nav: false,
      margin: 15,
      dots: false,
      lazyContent: true,
      autoplay: true,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 2
        },
        768: {
          items: 3
        },
        992: {
          items: 4
        }
      }
    });


  });

</script>
