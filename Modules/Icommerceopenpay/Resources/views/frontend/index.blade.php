@extends('layouts.master')

@section('title')
  Openpay | @parent
@stop


@section('content')
<div class="icommerce_openpay icommerce_openpay_index py-4">
  <div class="container">

    <div class="method-title text-center">
      <h2>Bienvenido - OpenPay</h2>
    </div>
    
    {{--Select Payment Modes--}}
    <div class="row justify-content-center">
        <div class="col-lg-9">
           @include('icommerceopenpay::frontend.partials.payment-modes')
        </div>
    </div>

    {{--PSE--}}
    <div class="row justify-content-center">
        <div class="col-lg-9">
          @include('icommerceopenpay::frontend.partials.pse')
        </div>
    </div>

    {{--Form Debit and Credits--}}
    <div class="row justify-content-center">
        <div class="col-lg-9">
          @include('icommerceopenpay::frontend.partials.form')
        </div>
    </div>
    
    {{--Loading--}}
    <div class="row justify-content-center">
        <div class="col-lg-9">
           @include('icommerceopenpay::frontend.partials.loading')
        </div>
    </div>

  </div>
</div>
@stop


@section('scripts')
@parent
 
 
<script type="text/javascript" src="https://resources.openpay.co/openpay.v1.min.js"></script>
<script type='text/javascript' src="https://resources.openpay.co/openpay-data.v1.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {


  initOpenpay();

  /*
  * Init Open Pay
  */
  function initOpenpay(){
    OpenPay.setId('{{$config->merchantId}}');
    OpenPay.setApiKey('{{$config->publicKey}}');
    OpenPay.setSandboxMode({{$config->sandboxMode}});

    var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
  }

  /*
  * Event - Select payment mode
  */
  $('#selectPaymentMode').on('change', function() {
    let selectMode = $('#selectPaymentMode').val();
    
    if(selectMode==0){
      $('#pse-form').hide();
      $('#payment-form').hide();
    }

    if(selectMode=="cards"){
      $('#pse-form').hide();
      $('#payment-form').show();
    }

    if(selectMode=="pse"){
      $('#payment-form').hide();
      $('#pse-form').show();
    }
    
  });

  /*
  * Event Click Pay Button
  */
  $('#pay-button').on('click', function(event) {
    event.preventDefault();
    $("#pay-button").prop( "disabled", true);
    OpenPay.token.extractFormAndCreate('payment-form', successCallback, errorCallback);
  });

  /*
  * Event Click PSE pay button
  */
  $('#pse-pay-button').on('click', function(event) {
    event.preventDefault();
    $("#pse-pay-button").prop( "disabled", true);
    processPaymentPse()
  });

  

  /*
  * Sucess Process Debit and Credits Cards
  */
  var successCallback = function(response) {
    //console.warn(response)
    var tokenId = response.data.id;
    processPayment(tokenId)
   
  };

  /*
  * Error Process Debit and Credits Cards
  */
  var errorCallback = function(response) {
    //console.warn(response)
    console.warn("============== ERROR CALL BACK")
    var desc = response.data.description != undefined ? response.data.description : response.message;
    alert("ERROR [" + response.status + "] " + desc);
    $("#pay-button").prop("disabled", false);

  };

  /*
  * API - Process Payment - Debit and Credits Cards
  */
  async function processPayment(token){

    $("#paymentModes").hide();
    $("#pay-button").hide();

    $("#loadingPayment").show();

    let url = "{{route('icommerceopenpay.api.openpay.processPayment')}}"
    
    let data = {
        orderId:{{$config->order->id}},
        transactionId:{{$config->transaction->id}},
        clientToken: token,
        deviceId: $('#deviceIdHiddenFieldName').val()
    }
    
    // FETCH
    let response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json;charset=utf-8'
      },
      body: JSON.stringify({attributes:data})
    });

    let result = await response.json();

    $("#loadingPayment").hide();
    
    // CHECK RESULT
    if(result){

      //let data = result.data;
      if(result.status=="success"){
        //console.warn(data.transaction)
        alert("PROCESO EXITOSO")

      }else{
        //$("#btnPay").show();
        $("#paymentModes").show();
        alert("ERROR: "+result.error)
      }

      let redirect = "{{$config->reedirectAfterPayment}}";
      finishedPayment(redirect)

    }
   

   
  }

   /*
  * API - Process Payment PSE
  */
  async function processPaymentPse(){

    $("#paymentModes").hide();
    $("#pse-pay-button").hide();

    $("#loadingPayment").show();

    let url = "{{route('icommerceopenpay.api.openpay.processPaymentPse')}}"
    
    let data = {
        orderId:{{$config->order->id}},
        transactionId:{{$config->transaction->id}}
    }
    
    // FETCH
    let response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json;charset=utf-8'
      },
      body: JSON.stringify({attributes:data})
    });

    let result = await response.json();
    console.warn(result)

    $("#loadingPayment").hide();
    
    // CHECK RESULT
    if(result){
      if(result.status=="success"){
        finishedPayment(result.pse.url)
      }else{
        $("#paymentModes").show();
        $("#pse-pay-button").show();
        alert("Ha ocurrido un error al obtener la información para PSE")
        console.warn("ERROR: "+result.error)
      }
    }
   

   
  }


  /*
  * Reedirect to order or to PSE
  */
  function finishedPayment(redirect){

    $('#dialogTitle').text("Reedireccionando...");
    $("#loadingPayment .alert").removeClass("alert-warning");
    $("#loadingPayment .alert").addClass("alert-success");

    $("#loadingPayment").show();

    window.location.href = redirect;

  }

});
</script>



@stop