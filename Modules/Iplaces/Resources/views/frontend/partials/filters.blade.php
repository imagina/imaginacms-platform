<h4 class="text-primary font-weight-bold mb-2">Filtrar por:</h4>

<form id="listFilters" class="border border-gray-lighter" method="get" action="{{route('iplaces.place.index')}}">

    @if(count($categories))
    <ul class="list-group list-group-flush">
        <li class="filter-title btn d-block text-gray-dark text-left bg-transparent shadow-none w-100 border-top
                       border-bottom border-gray-border border-left-0 border-right-0 rounded-0"
            data-toggle="collapse" href="#collapseG" role="button" aria-expanded="true"
            aria-controls="collapseG">
            <strong> Tipo de Lugar</strong>
            <span class="badge badge-pill pull-right pt-2"><i class="fa fa-caret-down"></i></span>
        </li>

        <div class="collapse pb-2 show" id="collapseG">
            @foreach($categories as $cat)
                <li class="list-group-item border-0 py-1" data-style="button">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="categories[]" id="customCheckc{{$cat->id}}" value="{{$cat->id}}" @isset($oldCat) @if(in_array($cat->id, $oldCat)) checked="checked" @endif @endisset>
                        <label class="custom-control-label " for="customCheckc{{$cat->id}}">{{$cat->title}}</label>
                    </div>
                </li>
            @endforeach
        </div>
    </ul>
    @endif

    <ul class="list-group list-group-flush list-gama">
        <li class="filter-title btn d-block text-gray-dark text-left bg-transparent shadow-none w-100 border-top
               border-bottom border-gray-border border-left-0 border-right-0 rounded-0">
            <strong> Gama </strong>
        </li>
        <div class="row  p-2 pb-3">

            <div class="col-4">

                <div class="custom-control custom-checkbox pl-0">
                    <input type="radio" class="custom-control-input" name="gama" id="customCheckexclusivo" value="0" @isset($oldGama) @if(0==$oldGama) checked="checked" @endif @endisset>
                    <label class="custom-control-label text-center " for="customCheckexclusivo">
                        <img class="img-fluid mx-auto mb-1" src="{{Theme::url('img/icon/exclusivo.png')}}">
                        <div class="texto">Lo más Exclusivo</div>
                    </label>
                </div>

            </div>
            <div class="col-4">
                <div class="custom-control custom-checkbox pl-0">
                    <input type="radio" class="custom-control-input" name="gama" id="customCheckalta" value="1" @isset($oldGama) @if(1== $oldGama) checked="checked" @endif @endisset>
                    <label class="custom-control-label text-center" for="customCheckalta">
                        <img class="img-fluid mx-auto mb-1" src="{{Theme::url('img/icon/alta.png')}}">
                        <div class="texto">Gama Alta</div>

                    </label>
                </div>
            </div>
            <div class="col-4">
                <div class="custom-control custom-checkbox pl-0">
                    <input type="radio" class="custom-control-input" name="gama" id="customCheckmedia" value="2" @isset($oldGama) @if(2==$oldGama) checked="checked" @endif @endisset>
                    <label class="custom-control-label text-center" for="customCheckmedia">
                        <img class="img-fluid mx-auto mb-1" src="{{Theme::url('img/icon/media.png')}}">
                        <div class="texto">Gama Media</div>
                    </label>
                </div>
            </div>
        </div>
    </ul>

    @if(count($cities))
    <ul class="list-group list-group-flush  mb-1">
        <li class="filter-title btn d-block text-gray-dark text-left bg-transparent shadow-none w-100 border-top
                       border-bottom border-gray-border border-left-0 border-right-0 rounded-0"
            data-toggle="collapse" href="#collapseA" role="button" aria-expanded="false"
            aria-controls="collapseA">
            <strong>Ubicaci&oacute;n</strong>
            <span class="badge badge-pill pull-right pt-2"><i class="fa fa-caret-down"></i></span>
        </li>
        <div class="collapse pb-2" id="collapseA">
            @foreach($cities as $city)
                @if(count($city->places))
                <li class="list-group-item border-0 py-1" data-style="button">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="cities[]" id="customChecks{{$city->id}}" value="{{$city->id}}" @isset($oldCity) @if(in_array($city->id, $oldCity)) checked="checked" @endif @endisset>
                        <label class="custom-control-label " for="customChecks{{$city->id}}">{{$city->translate('en')->name}}</label>
                    </div>
                </li>
                @endif
            @endforeach
        </div>
    </ul>
    @endif

    <ul class="list-group list-group-flush">
        <li class="filter-title btn d-block text-gray-dark text-left bg-transparent shadow-none w-100 border-top
               border-bottom border-gray-border border-left-0 border-right-0 rounded-0"
            data-toggle="collapse" href="#collapsesQP" role="button" aria-expanded="false"
            aria-controls="collapsesQP">
            <strong> Cantidad de Invitados </strong>
            <span class="badge badge-pill pull-right pt-2"><i class="fa fa-caret-down"></i></span>
        </li>
        <div class="collapse pb-2" id="collapsesQP">
            <li class="list-group-item border-0 py-1" data-style="button">
                <div class="custom-control custom-checkbox">
                    <input type="radio" class="custom-control-input" name="quantity_persons" id="customCheckqp1" value="200" @isset($oldQuan) @if(200==$oldQuan) checked="checked" @endif @endisset>
                    <label class="custom-control-label " for="customCheckqp1">200</label>
                </div>
            </li>
            <li class="list-group-item border-0 py-1" data-style="button">
                <div class="custom-control custom-checkbox">
                    <input type="radio" class="custom-control-input" name="quantity_persons" id="customCheckqp2" value="300" @isset($oldQuan) @if(00== $oldQuan) checked="checked" @endif @endisset>
                    <label class="custom-control-label " for="customCheckqp2">300</label>
                </div>
            </li>
            <li class="list-group-item border-0 py-1" data-style="button">
                <div class="custom-control custom-checkbox">
                    <input type="radio" class="custom-control-input" name="quantity_persons" id="customCheckqp3" value="500" @isset($oldQuan) @if(500==$oldQuan) checked="checked" @endif @endisset>
                    <label class="custom-control-label " for="customCheckqp3">400</label>
                </div>
            </li>
        </div>
    </ul>

    @if(count($zones))
    <ul class="list-group list-group-flush">
        <li class="filter-title btn d-block text-gray-dark text-left bg-transparent shadow-none w-100 border-top
                       border-bottom border-gray-border border-left-0 border-right-0 rounded-0"
            data-toggle="collapse" href="#collapseS" role="button" aria-expanded="false"
            aria-controls="collapseS">
            <strong>Tipo de zona</strong>
            <span class="badge badge-pill pull-right pt-2"><i class="fa fa-caret-down"></i></span>
        </li>
        <div class="collapse pb-2" id="collapseS">
            @foreach($zones as $zone)
                <li class="list-group-item border-0 py-1" data-style="button">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="zones[]" id="customCheckz{{$zone->id}}" value="{{$zone->id}}" @isset($oldZone) @if(in_array($zone->id, $oldZone)) checked="checked" @endif @endisset>
                        <label class="custom-control-label " for="customCheckz{{$zone->id}}">{{$zone->title}}</label>
                    </div>
                </li>
            @endforeach
        </div>
    </ul>
    @endif


    @if(count($schedules))
    <ul class="list-group list-group-flush">
        <li class="filter-title btn d-block text-gray-dark text-left bg-transparent shadow-none w-100 border-top
                       border-bottom border-gray-border border-left-0 border-right-0 rounded-0"
            data-toggle="collapse" href="#collapseschedule" role="button" aria-expanded="false"
            aria-controls="collapseschedule">
            <strong> Horarios </strong>
                    <span class="badge badge-pill pull-right pt-2"><i class="fa fa-caret-down"></i></span>
        </li>
        <div class="collapse pb-2" id="collapseschedule">
            @foreach($schedules as $schedule)
                <li class="list-group-item border-0 py-1" data-style="button">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="zones[]" id="customCheckh{{$schedule->id}}" value="{{$schedule->id}}" @isset($oldSchedule) @if(in_array($schedule->id, $oldSchedule)) checked="checked" @endif @endisset>
                        <label class="custom-control-label " for="customCheckh{{$schedule->id}}">{{$schedule->title}}</label>
                    </div>
                </li>
            @endforeach
        </div>
    </ul>
    @endif


</form>



@section('scripts')
    @parent

    <script>
        $(document).ready(function () {
            $('input[type="checkbox"], input[type="radio"]').on('change', function () {
                $("#listFilters").submit();
            });
        });

    </script>

@stop