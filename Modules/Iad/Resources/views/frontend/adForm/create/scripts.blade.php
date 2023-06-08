@section('scripts')
@parent
<!-- Image upload -->
<script src="https://unpkg.com/vue-image-upload-resize"></script>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" />

<script>

/********* VUE ***********/
var vue_ad_create = new Vue({
  el: '#content_form_ad',
  components: {},
  data: {
    //Loaded data
    rates: [
      {label : '1 Hora', value : '1hora'},
      {label : '3 Hora', value : '3hora'},
      {label : '5 Hora', value : '5hora'},
    ],
    provinces: [],
    cities: [],
    neighborhoods: [],
    tagsMe: [],
    tagsPlace: [],
    lattitude: "",
    longitude: "",
    address: "",
    //form
    form:{
      rates:[
        {
          rate_id:'',
          price:''
        }
      ],
      services:[],
      tags:[],
      category_id:"",
      province_id:"",
      city_id:"",
      neighborhood_id:"",
      title:"",
      slug:"",
      description:"",
      options:{
        address:"",
        sameSchedule:1,
      },
    },
    fields:{
      address:"",
      phone:"",
      note:"",
      name:"",
      age:"18",
      customer_feedback:"",
      independent_escort:false,
      mainImage:"{{asset('modules/iad/img/default.jpg')}}",
    },
    hasImage :false,
    image :null,
  },
  computed:{
    makeSlug(){
      var text = this.form.title;
      text = text.toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
      this.form.slug=text;
    }

  },
  created: function () {
    // logs:
    // "m[foo] = 3"
    // "m[bar] = [object Object]"
    // "m[baz] = undefined"
    this.$nextTick(function () {
      this.getProvinces();
      this.getMeTags();
      this.getPlaceTags();
    });
  },

  methods: {
    setImage: function (file) {
    this.hasImage = true;
    this.image = file;
    this.fields.mainImage=this.image;
    console.log('image');
    console.log(this.image);
    },
    startImageResize: function (file) {
    console.log('file');
    console.log(file);
    },
    endImageResize: function (file) {
    console.log('file');
    console.log(file);
    },
    getProvinces() {
      axios({
        method: 'Get',
        responseType: 'json',
        url: "{{ route('api.ilocations.provinces.index') }}",
        params: {
          filter:{
            country:48,
            allTranslations:1
          }
        }
      }).then(response => {
        this.provinces=response.data.data;
      });

    },
    getPlaceTags() {
      axios({
        method: 'Get',
        responseType: 'json',
        url: "{{ route('api.tag.tag.by-namespace') }}",
        params: {
          namespace:"place"
        }
      }).then(response => {
        this.tagsPlace=response.data;
      });

    },
    getMeTags() {
      axios({
        method: 'Get',
        responseType: 'json',
        url: "{{ route('api.tag.tag.by-namespace') }}",
        params: {
          namespace:"aboutMe"
        },
        headers: {
        }
      }).then(response => {
        this.tagsMe=response.data;
      });

    },

    getCities() {
      axios({
        method: 'Get',
        responseType: 'json',
        url: "{{ route('api.ilocations.cities.index') }}",
        params: {
          filter:{
            province_id:this.form.province_id,
            allTranslations:1
          }
        }
      }).then(response => {
        this.cities=response.data.data;
        if(response.data.data.length==0)
        toastr.warning('No se han encontrado ciudades para esta provincia.', 'Notificación')
      });

    },

    getNeighborhoods() {
      axios({
        method: 'Get',
        responseType: 'json',
        url: "{{ route('api.ilocations.neighborhoods.index') }}",
        params: {
          filter:{
            city:this.form.city_id,
            allTranslations:1
          }
        }
      }).then(response => {
        this.neighborhoods=response.data.data;
        if(response.data.data.length==0)
        toastr.warning('No se han encontrado barrios para esta ciudad.', 'Notificación')
      });

    },
    saveAd(){
      let data=this.form;
      if(data.category_id==""){
        toastr.error('Debes seleccionar una categoría.', 'Error!')
        return false;
      }else if(data.province_id==""){
        toastr.error('Debes seleccionar una provincia.', 'Error!')
        return false;
      }else if(data.city_id==""){
        toastr.error('Debes seleccionar una ciudad.', 'Error!')
        return false;
      }else if(this.fields.address==""){
        toastr.error('Debes escribir tu ubicación.', 'Error!')
        return false;
      }else if(this.fields.phone==""){
        toastr.error('Debes escribir tu teléfono.', 'Error!')
        return false;
      }else if(data.title==""){
        toastr.error('Debes escribir el título del anuncio.', 'Error!')
        return false;
      }else if(this.fields.name==""){
        toastr.error('Debes escribir un nombre.', 'Error!')
        return false;
      }else{
        //Fields arr
        let fields=[];
        //Each fields
        for (const entry of Object.entries(this.fields)) {
          fields.push({"name":entry[0],"value":entry[1]})
        }
        //Add fields to form
        data.fields=fields;
        axios.post("{{route('api.iad.ads.create')}}", {
          attributes:data
        }).then(response=> {
          toastr.success('Datos almacenados correctamente.', 'Registro exitoso');
          setTimeout(function () {
            window.location.reload();
          }, 4000);
        }).catch(function (error) {
          let errors=JSON.parse(error.response.data.errors);
          for(let e in errors){
            toastr.error(errors[e], 'Error!')
          }
        });
      }//else
    }

  }
});

</script>



<!-- MAP -->

<!-- no scripts -->
<script type='text/javascript'
        src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
<script type='text/javascript'
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBntWHoJz0Q1aR_qpGH8dN1Oi2Q0pgf9Kw&extension=.js&output=embed"></script>
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
                    $("#addresshidd").val(address_values);
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
                    $("#addresshidd").val(JSON.stringify(address_values));
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
    .tagBoxs {
      border: 1px solid #ccc!important;
      border-color: #000!important;
      padding: 0.01em 16px;
      margin-left: 0.5rem !important;
      margin-right: 0.5rem !important;
    }
    .tagBoxs label {
      cursor: pointer;
      font-size: 1em;
      -webkit-transition: all 0.3s ease;
      -o-transition: all 0.3s ease;
      transition: all 0.3s ease;
    }

    #content_form_ad .form-control {
      border-radius: 13px;
    }

    .card-collapse {
      margin-bottom: 20px;
    }
    .card-collapse a[aria-expanded="true"] .fa-chevron-circle-right:before {
      content: "\f13a";
    }

    .card-collapse .card-header {
      background-color: #efefef;
      border-radius: 10px;
      border: 0;
    }

    /* Arrow & Hover Animation */
     #more-arrows {
    	 width: 75px;
    	 height: 65px;
    }
     #more-arrows:hover polygon {
    	 fill: #fff;
    	 transition: all 0.2s ease-out;
    }
     #more-arrows:hover polygon.arrow-bottom {
    	 transform: translateY(-18px);
    }
     #more-arrows:hover polygon.arrow-top {
    	 transform: translateY(18px);
    }
     polygon {
    	 fill: #fff;
    	 transition: all 0.2s ease-out;
    }
     polygon.arrow-middle {
    	 opacity: 0.75;
    }
     polygon.arrow-top {
    	 opacity: 0.5;
    }



</style>
@stop
