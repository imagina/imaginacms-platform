<div class="col-12">
  @if(isset($title) && !empty($title))
    <p class="subtitle h3">{{$title}}</p>
    <hr>
  @endif
  <div class="section-map">
    <div class="map bg-light">
      @if($settingMap == 'googleMaps')
        <div class="content">
          <div id="{{$mapId}}" class="{{$classes}} maps-component" style="width:100%; height:314px"></div>
        </div>
      @elseif($settingMap == 'openStreet')
        <div class="content">
          <div id="{{$mapId}}" class="map map-home" style="width:100%; height:314px;"></div>
        </div>
      @endif
    </div>
  </div>
</div>

@if($settingMap == 'openStreet')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css">
  <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
  <script>
    var osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
      osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      osm = L.tileLayer(osmUrl, {maxZoom: {{$zoom}}, attribution: osmAttrib});
    var map = L.map('{{$mapId}}').setView([{{$lat}}, {{$lng}}], {{$zoom}}).addLayer(osm);
    L.marker([{{$lat}}, {{$lng}}])
      .addTo(map)
      .bindPopup('{{$locationName}}')
      .openPopup();
  </script>
@else

  <script>

@if(!isset($inModal) || !$inModal)

document.addEventListener("DOMContentLoaded", function () {
@endif
    function initMap() {
      const position = {lat: {{$lat}}, lng: {{$lng}}};
      const map = new google.maps.Map(document.getElementById("{{$mapId}}"), {
        zoom: {{$zoom}},
        center: position,
      });
      const marker = new google.maps.Marker({
        position: position,
        map: map,
      });
    }

	initMap();
@if(!isset($inModal) || !$inModal)
 });
@endif

  </script>
@endif
