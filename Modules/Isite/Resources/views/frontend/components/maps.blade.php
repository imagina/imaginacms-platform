<div class="component-map map-{{$settingMap}}">
  @if($withTitle)
    <div class="title-section {{$alignTitle}}">
      {{$title}}
    </div>
  @endif
  <div class="section-map">
    <div class="map bg-light">
      @if($settingMap == 'googleMaps')
        <div class="content">
          <div id="{{$mapId}}" class="{{$classes}} maps-component"
               style="width:{{$mapWidth}}; height:{{$mapHeight}}"></div>
        </div>
      @elseif($settingMap == 'openStreet')
        <div class="content">
          <div id="{{$mapId}}" class="map map-home" style="width:{{$mapWidth}}; height:{{$mapHeight}}"></div>
        </div>
      @endif
    </div>
  </div>
</div>

<style>

    @if(!empty($colorTitleSection) && !empty($fontSizeTitleSection))
      .component-map .title-section {
        color: {{$colorTitleSection}};
        font-size: {{$fontSizeTitleSection}}px;
    }
  @endif

</style>

@if($settingMap == 'openStreet')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
          integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
          crossorigin=""></script>
  <script>
    var osmUrl = '{{$mapStyle}}',
      osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      osm = L.tileLayer(osmUrl, {maxZoom: {{$maxZoom}}, minZoom: {{$minZoom}}, attribution: osmAttrib});
    var map = L.map('{{$mapId}}').setView([{{$centerLat}}, {{$centerLng}}], {{$zoom}}).addLayer(osm);
    @if(isset($imageIcon) && !is_null($imageIcon))
    var mapIcon = L.icon({
      iconUrl: '{{$imageIcon}}',
      className: '{{$markerMapClasses}}',
      iconSize: [{{$iconWidth}}, {{$iconHeight}}], // size of the icon
      iconAnchor: [{{$iconMarginLeft}}, {{$iconMarginTop}}], // point of the icon which will correspond to marker's location
    });
    @endif
    @foreach($locations as $location)
    var myMarker = L.marker([{{$location['lat']}}, {{$location['lng']}}], @if(isset($imageIcon) && !is_null($imageIcon)){icon: mapIcon}@endif)
      .addTo(map)
      .bindPopup('{{$location['title']}}')
      .openPopup();
    @if(isset($mapEvent) & !is_null($mapEvent))
    myMarker.on({
      click: function (e) {
        window.livewire.emit('{{$mapEvent}}', {{$location['id']}});
      }
    });
    @endif
    @endforeach
  </script>

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

