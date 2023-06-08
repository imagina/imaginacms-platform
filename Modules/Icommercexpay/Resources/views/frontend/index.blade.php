@php
  $layout = 'layouts.master';
  if(!(View::exists($layout))){
    $layout ="icommercexpay::frontend.layouts.master";
  }
@endphp

@extends($layout)

@section('title')
  xPay | @parent
@stop

@section('content')

<div class="icommerce_xpay_index py-5">
  <div id="content_xpay">
  
    <div class="container">

      <h2 class="text-center font-weight-bold mt-5">Bienvenido</h2>
      <hr>

      <div class="row my-5 justify-content-center">

        <div class="col-xs-12 col-md-8">
        
          <div v-if="success" class="card text-center">

            <div class="card-header bg-secondary">
              <h3 class="font-weight-bold text-white">xPay</h3>
            </div>

            @include("icommercexpay::frontend.partials.loading")

            <div v-if="!dataError" class="card-body py-5 px-4">

                @include("icommercexpay::frontend.partials.currencies")
  
                @include("icommercexpay::frontend.partials.payment")

                @include("icommercexpay::frontend.partials.finished")

            </div>

            <div v-else class="card-body py-5 px-4">
              <div class="alert alert-danger" role="alert">
                Ha ocurrido un error comuniquese con el administrador
              </div>
            </div>

            <div class="card-footer text-muted">
              xPay - {{date('Y')}}
            </div>

          </div>
      
        </div>


        <div class="col-xs-12 col-md-4">
          @include("icommercexpay::frontend.partials.information")
        </div>
      
      </div>

      <hr>

    </div>

  </div>
</div>

@stop

@section('scripts')
@parent
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script type="text/javascript">

var index_xpay = new Vue({
  el: '#content_xpay',
  created() {
    this.$nextTick(function () {
      this.init();
    })
  },
  data: {
    currentStep: 1,
    loading: true,
    success: false,
    dataError: {!! $dataError['status'] ? $dataError['status']: 0 !!},
    dataErrorMsj: {!! $dataError['msj'] ? $dataError['msj']: 0 !!},
    data: {!! json_encode($data) !!},
    dataPayment:null,
    selectedCurrency: null,
    dataEvent:null
  }, 
  methods: {
    init(){
      this.success = true;
      this.loading = false;

      if(this.dataError)
        console.error(this.dataErrorMsj)
     
    },
    generatePayment(){

      this.loading = true;
      let path = "{{route('icommercexpay.api.xpay.createPayment')}}"
      let attributes2 = {
        encrp:this.data.encrp,
        srcCurrency: this.selectedCurrency.currency.code,
        exchangeId: this.selectedCurrency.exchange
      }

      axios.post(path, {attributes:attributes2})
      .then(response => {
        this.dataPayment = response.data;
        this.initPush()
        this.initTime();
      })
      .catch(error => {

        if (error.response)
          console.log(error.response.data.errors)

        this.dataError = true;
       
      })
      .finally(() => this.loading = false)
      
     
    },
    finishedPayment(){
      //console.warn(this.dataEvent)
      let redirect = "{{url("/")}}"; 
      setTimeout(function () {
        window.location.href = redirect;
      }, 5000); 
    },
    onStep(nextStep){
      this.currentStep = nextStep;
      if(this.currentStep==2)
        this.generatePayment();

      if(this.currentStep==3)
        this.finishedPayment();
    },
    initTime(){
      if(this.dataPayment){
        let xpaytoreload = 0;
        let waitingTime = this.dataPayment.waiting_time;
        var xpaytimer = setInterval(function(){
          if (typeof jQuery == 'undefined') return;
          var $ = jQuery;
          var t = $('#xpay-timer');
          if (t.length > 0) {
            ++xpaytoreload;
            var s = waitingTime;
            --s;
            --waitingTime;
            if (s < 0) {
              t.html('EXPIRADO');

              let redirect = "{{url("/")}}"; 
              window.location.href= redirect;

              clearInterval(xpaytimer);
              return;
            }
            var mm = parseInt(s/60);
            var ss = s%60;
            if (mm < 10) mm = '0'+mm;
            if (ss < 10) ss = '0'+ss;
            t.html(mm+':'+ss);
          }
        }, 950);
      }
    },
    initPush(){

      // Enable pusher logging - don't include this in production
      Pusher.logToConsole = true;

      let p_app_key = "{!!env('PUSHER_APP_KEY')!!}"
      let p_app_cluster = "{!!env('PUSHER_APP_CLUSTER')!!}"

      var pusher = new Pusher(p_app_key, {
        cluster: p_app_cluster,
        encrypted: true
      });

      var myEvent = "responseXpay"+this.data.order.id
      var channel = pusher.subscribe('global');
     
      channel.bind(myEvent, function(data) {
        index_xpay.dataEvent = {
          xpayTranId:data.xpayTranId,
          xpayTranStatus:data.xpayTranStatus,
          orderId:data.orderId
        }
        index_xpay.onStep(3)
      });
    
    },
    copyText(myInput){
      var copyText = document.getElementById(myInput);
      copyText.select();
      copyText.setSelectionRange(0, 99999); /*For mobile devices*/
      document.execCommand("copy");
    }
  },
  computed: {
    sortedCurrencies(){
      return this.data.currencies.sort((a, b) => (a.currency.name > b.currency.name) ? 1 : -1)
    }
  }
})

</script>
@stop

<style>
  #capa {
      width: 100%;
      top: 0;
      left: 0;
      background-color: rgba(255, 255, 255, 0.95);
      z-index: 9999;
  }
  .flex-center{
      align-items: center;
      display: flex;
      justify-content: center;
  }
  .full-height {
      height: 100%;
  }
</style>