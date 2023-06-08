<div class="modal modal-pin fade" id="modalPin{{$item->id}}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <img class="img-fluid" src="{{Theme::url('pins-publication/close.png')}}" alt="pin-1">
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-6 pb-4">
              <div class="modal-images">
                <div id="carouselGallery" class="carousel slide mb-2" data-ride="carousel">
                  <a class="carousel-control-prev" href="#carouselGallery" role="button" data-slide="prev">
                    <span class="fa fa-caret-right" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselGallery" role="button" data-slide="next">
                    <span class="fa fa-caret-left" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <a
                        href="https://sexy-latinas.imaginacolombia.com/assets/Iad/ad/3YfGSuM7p8/gallery/0ZiUpnEdBa3yjZ7Xbd0gBl3zLA6m5ugK.jpg"
                        data-fancybox="gallery" data-caption="Nombre persona">
                        <picture class="slider-cover">
                          <x-media::single-image :alt="$item->title ?? $item->name"
                                                 :title="$item->title ?? $item->name"
                                                 :url="$item->url ?? null" :isMedia="true"
                                                 imgClasses=""
                                                 :mediaFiles="$item->mediaFiles()"/>
                        </picture>
                      </a>
                    </div>
                  </div>
                </div>
                <!--carusel de abajo-->
                <div class="owl-carousel owl-image-mini owl-theme">
                  <div class="item">
                    <picture class="slider-cover">
                      <x-media::single-image :alt="$item->title ?? $item->name"
                                             :title="$item->title ?? $item->name"
                                             :url="$item->url ?? null" :isMedia="true"
                                             imgClasses=""
                                             :mediaFiles="$item->mediaFiles()"/>
                    </picture>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 pb-4">
              <h2 class="modal-title mb-3">
                {{$item->title}}
              </h2>
              @if(isset($item->city->name))
                <span class="badge info-badge">
                {{--Medellín--}}
                  {{$item->city->name}}
                </span>
              @endif
              @if(isset(collect($item->fields)->where('name','age')->first()->value))
                <span class="badge info-badge">
                  {{--21 años--}}
                  {{collect($item->fields)->where('name','age')->first()->value}} años
                </span>
              @endif
              <span class="badge info-badge">${{formatMoney($item->min_price)}}</span>
              <span class="badge info-badge">{{$item->country->name}}</span>
              @if($item->status == 3)
                <span class="badge info-badge certified" title="{{trans("iad::status.checked")}}"></span>
              @endif
              @php($videos = $item->mediaFiles()->videos)
              @if(count($videos)>0)
                <span class="badge info-badge videos">{{count($videos)}}</span>
              @endif
              <p class="modal-date my-3">
                {{date("d/m/Y H:i",strtotime($item->created_at))}}
              </p>
              <div class="modal-description">
                {!! nl2br ($item->description) !!}
                {!! $item->options->secondaryDescription ?? "" !!}
              </div>
              <div class="group-btn">
                @if(isset(collect($item->fields)->where('name','whatsapp')->first()->value))
                  <a class="btn btn-whatsapp" href="" target="_blank">
                    <i class="fa fa-whatsapp"></i> WhatsApp
                  </a>
                @endif
                @if(isset(collect($item->fields)->where('name','twitter')->first()->value))
                  <a class="btn btn-twitter"
                     href="" target="_blank">
                    <i class="fa fa-twitter"></i>twitter
                    {{collect($item->fields)->where('name','twitter')->first()->value}}
                  </a>
                @endif
                @if(isset(collect($item->fields)->where('name','phone')->first()->value))
                  <a class="btn btn-phone" href="tel:collect($item->fields)->where('name','phone')->first()->value"
                     target="_blank">
                    <i class="fa fa-mobile"></i> {{collect($item->fields)->where('name','phone')->first()->value}}
                  </a>
                @endif
                <a class="btn btn-like"
                   onClick="window.livewire.emit('addToWishList',{{json_encode(["entityName" => "Modules\\Iad\\Entities\\Ad", "entityId" => $item->id])}})">
                  <i class="fa fa-heart"></i>
                </a>
              </div>

            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <hr class="mb-4">
            </div>
          </div>
          <div class="row">
            <!--Rates-->
            @if(isset($item->options->prices))
              <div class="col-lg-6 pb-4">
                <h3 class="modal-title mb-3">
                  Tarifas
                </h3>
                @foreach($item->options->prices as $rate)
                  <div class="row align-items-center modal-item">
                    <div class="col-5 col-sm-3">{{$rate->description}}</div>
                    <div class="col-2 col-sm-5">
                      <hr class="solid">
                    </div>
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
                @foreach($item->options->schedule as $schedule)
                  <div class="row align-items-center modal-item">
                    <div class="col-5 col-sm-4">
                      {{trans("iad::schedules.days.".$schedule->name)}}
                    </div>
                    <div class="col-2 col-sm-4">
                      <hr class="solid">
                    </div>
                    <div class="col-5 col-sm-4 text-primary">
                      @if($schedule->schedules == 1)
                        {{trans("iad::schedules.schedules.24Hours")}}
                      @else
                        @foreach($schedule->schedules as $shift)
                          {{date("g:ia",strtotime($shift->from))}} -
                          {{date("g:ia",strtotime($shift->to))}}
                        @endforeach
                      @endif
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
            <div class="col-lg-12 pb-4">
              <hr>
            </div>
          </div>
          <div class="row">
            <!--About me-->
            @php
              $categories = app('Modules\Iad\Repositories\CategoryRepository')->getItemsBy(json_decode(json_encode([])));
            @endphp
            @foreach($categories->toTree() as $categoryParent)
              @php($categoriesAd = array_intersect($item->categories->pluck("id")->toArray(),$categoryParent->children->pluck("id")->toArray()))
              @if(!empty($categoriesAd))

                <div class="col-12 pb-4">
                  <h3 class="modal-title mb-3">
                    {{$categoryParent->title}}
                  </h3>
                  @foreach($categoriesAd as $categoryId)
                    @php($categoryAd = $item->categories->where("id",$categoryId)->first())
                    <span class="badge info-badge">{{$categoryAd->title}}</span>
                  @endforeach
                </div>
              @endif
            @endforeach
            <div class="col-lg-12 pb-4">
              <hr>
            </div>
          </div>
          @if(isset($item->options->map->title) && !empty($item->options->map->lat) && !empty($item->options->map->lng))
            <div class="col-12">
              <x-isite::Maps :lat="$item->options->map->lat" :lng="$item->options->map->lng"
                             locationName="{{$item->options->map->title}}" zoom="16"/>
            </div>
          @endif
        </div>

      </div>

      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-auto">
              <a class="btn btn-flag" data-toggle="collapse" href="#collapsePin{{$item->id}}" role="button"
                 aria-expanded="false" aria-controls="collapsePin{{$item->id}}">
                <img class="img-fluid" src="{{Theme::url('pins-publication/ico-denunciar.png')}}" alt="Flag this ad">
                Denunciar éste anuncio
              </a>
            </div>
            <div class="col-12">
              <div class="collapse mt-4" id="collapsePin{{$item->id}}">
                <div class="card card-body pt-4 bg-light">

                  {!! Forms::render('denuncia','iforms::frontend.form.bt-nolabel.form') !!}

                  <p class="text-justify mt-4 mb-0"><strong>Nota:</strong> Si el motivo de la denuncia es que eres la
                    persona que aparece en las fotos y quieres eliminar el anuncio, y no tienes acceso ni al email que
                    se usó para publicarlo ni al teléfono que aparece en el anuncio, debes indicarnos un teléfono y
                    email para que podamos contactar contigo y confirmar que realmente eres tú.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>