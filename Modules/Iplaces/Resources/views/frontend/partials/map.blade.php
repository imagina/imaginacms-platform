@if(isset($place->address)&&!empty($place->address))
  <div class="map bg-light">
    <h3 class="text-center py-4">¿Dónde está Ubicado?</h3>
    <div class="content">
      <x-isite::Maps lat="{{$place->address->lat}}" lng="{{$place->address->lng}}"
                     locationName="{{$place->address->title}}"
                     zoom="18"/>
    </div>
  </div>
@endif