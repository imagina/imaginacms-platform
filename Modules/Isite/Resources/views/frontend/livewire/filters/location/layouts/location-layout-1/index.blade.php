<div class="filter-{{$type}} filter-{{$type}}-layout-{{$layout}} filter-{{$name}}">

	<div class="d-flex">

		<input
	        type="text"
	        name="input-search-location"
	        id="input-search-location"
	        autocomplete="off"
	        placeholder="{{trans('isite::frontend.filter-location.input-placeholder')}}"
            value="{{$inputSearchLocation}}"
            wire:ignore>

	    <div id="locate" class="locate" title="{{trans('isite::frontend.filter-location.title-nearme')}}">
	        <div class="locate-icon-wrapper d-flex justify-content-center align-items-center">

                <i id="locate-near-icon" class="fa fa-dot-circle-o text-primary cursor-pointer" aria-hidden="true"></i>

	        </div>
	    </div>

	  	@if(!empty($radio))
		    <div class="search-location-radius">
		        <select id="select-radius" wire:model="selectedRadio">
                    <option value="all">Todo</option>
		        	@foreach($radio['values'] as $key => $value)
			            <option value="{{$value}}">{{$value}} {{$radio['measure']}}</option>
			        @endforeach
		        </select>
		    </div>
		@endif


	</div>

</div>

@section('scripts-owl')
    @parent

    <script>

        $(document).ready(function () {

            // emit To Parent Filter
            function emitToParentFilterLocation(lat,lng,updateItemList){

                window.livewire.emit('filtersGetData',{
                    'name' : 'location-range',
                    'filter' : {
                        'nearby':{
                            "radio":@this.selectedRadio,
                            "lat":lat,
                            "lng":lng
                        }
                    },
                    'eventUpdateItemsList':updateItemList
                }) 
            }

            // Init Geolocation
            function initGeolocation(){

                if ("geolocation" in navigator){
                    navigator.geolocation.getCurrentPosition(showLocation, showError, {timeout:2000, enableHighAccuracy: true}); //position request

                }else{
                    console.log("Browser doesn't support geolocation!");
                }
            }

            //Success Callback
            function showLocation(position){

            	@this.lat = position.coords.latitude;
            	@this.lng = position.coords.longitude;

                @this.inputSearchLocation = "{{trans('isite::frontend.filter-location.title-nearme')}}";

            	$("#input-search-location").val("{{trans('isite::frontend.filter-location.title-nearme')}}");

                // No event Button
                /*
                if(@this.startGeolocation)
                    emitToParentFilterLocation(position.coords.latitude,position.coords.longitude,true)
                    @this.startGeolocation = false;
                */

            }

            //Error Callback
            function showError(error){
               switch(error.code) {
                    case error.PERMISSION_DENIED:
                        alert("{{trans('isite::frontend.filter-location.geolocation.denied')}}");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        alert("{{trans('isite::frontend.filter-location.geolocation.unavailable')}}");
                        break;
                    case error.TIMEOUT:
                        alert("{{trans('isite::frontend.filter-location.geolocation.timeout')}}");
                        break;
                    case error.UNKNOWN_ERROR:
                        alert("{{trans('isite::frontend.filter-location.geolocation.error')}}");
                        break;
                }
            }

            // Get City (0), Deparment (1), Country(2) from Google
            function getPlaceInfor(placeAC){

                var inforPlace = []

                var componentMap = {
                    country: 'country',
                    locality: 'locality',
                    administrative_area_level_1 : 'administrative_area_level_1',
                };

                for(var i = 0; i < placeAC.length; i++){
                    var types = placeAC[i].types; // get types array of each component
                    for(var j = 0; j < types.length; j++){

                        var component_type = types[j];
                        if(componentMap.hasOwnProperty(component_type)){
                            if(component_type=="locality")
                                inforPlace[0] = placeAC[i]['short_name']

                            if(component_type=="administrative_area_level_1")
                                inforPlace[1] = placeAC[i]['short_name']

                            if(component_type=="country")
                                inforPlace[2] = placeAC[i]['short_name']
                        }
                    }
                }

                return inforPlace;
            }


            /**
            * Event Click Locate Near Icon
            */
            const el = document.getElementById("locate-near-icon");
            el.addEventListener("click", initGeolocation, false);


            // Google Maps Places INIT
            var searchInputLocation = 'input-search-location';
            var autocomplete;

            autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInputLocation)), {
                types: ['geocode'],
                componentRestrictions: {
                    country: "COL"
                }
            });

            /**
            *Event Place Changed
            */
            google.maps.event.addListener(autocomplete, 'place_changed', function () {

                var near_place = autocomplete.getPlace();
                var placeInformation = []

                //console.warn(near_place.address_components)

                placeInformation = getPlaceInfor(near_place.address_components)

                @this.city = placeInformation[0]
                @this.province = placeInformation[1]
                @this.country = placeInformation[2]

                @this.lat = near_place.geometry.location.lat();
                @this.lng = near_place.geometry.location.lng();

            });

            /**
            * Event Input Empty
            */
            const isEmpty = str => !str.trim().length;
            document.getElementById(searchInputLocation).addEventListener("input", function() {
              if( isEmpty(this.value) ) {

                @this.city = ''
                @this.province = ''
                @this.country = ''
                @this.lat = ''
                @this.lng = ''

              } else {
                //console.log( `NAME value is: ${this.value}` );
              }
            });

            /**
            * Start Geolocation First Request
            */
            /*
            if(@this.startGeolocation)
                initGeolocation()
            */

                

        });
    </script>
@stop
