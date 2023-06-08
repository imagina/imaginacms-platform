<!-- field_type_name -->
<div class='form-group{{ $errors->has("address") ? ' has-error' : '' }}'>
<div>
    <label>{!! $field['label'] !!}</label>
    <!-- this is an example of reverse geocoding an address and obtaining
Lat and long data, it includes TypeAhead suggestions, try it out by typing into the
Adress field below -->
    <?php
    if (isset($field['value'])) {
        $field_values = json_decode($field['value']);
    } else {
        $field_values = [];
    }

    ?>

        <div class="container_fluid">
            <input id="address" name="{{$field['name']}}[]" class="form-control input-md" placeholder="Address"
                   value="{{$field_values->address or ''}}">
            <div id="map_canvas" style="width:100%; height:300px"></div>
            <br>
            <div class="row">
                <div class="col-md-3">
                    <input id="latitude" name="{{$field['name']}}[]" type="hidden"
                           value="{{$field_values->lattitude or ''}}">
                </div>
                <div class="col-md-3">
                    <input id="longitude" name="{{$field['name']}}[]" type="hidden"
                           value="{{$field_values->longitude or ''}}">
                </div>
            </div>
        </div>

        <div class="container">
            <input
                    type="hidden"
                    id="{{$field['name']}}hidd"
                    name="{{ $field['name'] }}"
                    value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] :  '' ) }}"
            >
        </div>
       {!! $errors->first("address", '<span class="help-block">:message</span>') !!}
    </div>


    {{-- HINT --}}


</div>

@push('js-stack')
    <!-- no scripts -->
    {!! Theme::script('vendor/jquery-ui/jquery-ui.js')!!}
    <script type='text/javascript'
            src="https://maps.googleapis.com/maps/api/js?key={{setting('iplaces::api-maps')}}&extension=.js&output=embed"></script>
    <script type="text/javascript">

        var geocoder;
        var map;
        var marker;

        function initialize() {
//MAP
            var latitude = $('#latitude').val();
            var longitude = $('#longitude').val();
            var OLD = new google.maps.LatLng(latitude, longitude);
            var options = {
                zoom: 16,
                center: OLD,
                mapTypeId: google.maps.MapTypeId.ROADMAP,// ROADMAP | SATELLITE | HYBRID | TERRAIN
            };

            map = new google.maps.Map(document.getElementById("map_canvas"), options);

            //GEOCODER
            geocoder = new google.maps.Geocoder();

            marker = new google.maps.Marker({
                map: map,
                draggable: true,
                position: OLD
            });

        }

        $(document).ready(function () {

            initialize();

            $(function () {
                $("#address").autocomplete({
                    //This uses the geocoder to fetch the address values
                    source: function (request, response) {
                        geocoder.geocode({'address': request.term}, function (results, status) {
                            response($.map(results, function (item) {
                                return {
                                    label: item.formatted_address,
                                    value: item.formatted_address,
                                    latitude: item.geometry.location.lat(),
                                    longitude: item.geometry.location.lng()
                                }
                            }));
                        })
                    },
                    //This is executed upon selection of an address
                    select: function (event, ui) {
                        $("#latitude").val(ui.item.latitude);
                        $("#longitude").val(ui.item.longitude);
                        var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
                        marker.setPosition(location);
                        map.setCenter(location);
                        address_values = {
                            "address": $("#address").val(),
                            "longitude": $("#longitude").val(),
                            "lattitude": $("#latitude").val()
                        };
                        $("#{{$field['name']}}hidd").val(JSON.stringify(address_values));
                    }
                });
            });

            //Add a listener to the marker for reverse geocoding
            google.maps.event.addListener(marker, 'drag', function () {
                geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $('#address').val(results[0].formatted_address);
                            $('#latitude').val(marker.getPosition().lat());
                            $('#longitude').val(marker.getPosition().lng());
                        }
                        address_values = {
                            "address": $("#address").val(),
                            "longitude": $("#longitude").val(),
                            "lattitude": $("#latitude").val()
                        };
                        $("#{{$field['name']}}hidd").val(JSON.stringify(address_values));
                    }
                });
            });
        });
    </script>
    <style>
        .ui-autocomplete {
            background-color: white;
            width: 300px;
            border: 1px solid #cfcfcf;
            list-style-type: none;
            padding-left: 0px;
        }
    </style>
@endpush


