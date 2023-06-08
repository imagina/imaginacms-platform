@extends('layouts.master')

@section('title')
  Paymentez | @parent
@stop


@section('content')
<div class="icommerce_paymentez icommerce_paymentez_index py-5">
    <div class="container">
  
     <div class="row my-5 py-5 justify-content-center">

      <div class="card text-center">
        <h5 class="card-header bg-primary text-white">Paymentez - Bienvenido</h5>
        <div class="card-body">
          
          <p class="card-text">Haz click en el boton para iniciar el proceso de pago</p>
          <button id="btnPay" class="btn btn-primary js-payment-checkout">
            PAGAR
          </button>

          {{-- LOADING --}}
          <div id="loadingPayment" class="my-3" style="display:none">
            <div class="alert alert-warning" role="alert">
              <span id="dialogTitle">Espere un momento por favor</span>
            </div>
          </div>


          {{--
          <div id="response"></div>
          --}}
         
        </div>

        <div class="card-footer text-muted">
          Paymentez - {{date("Y")}}
        </div>

      </div>
 
     </div>
  
    </div>
</div>
@stop

@section('scripts')
@parent

<script src="https://cdn.paymentez.com/ccapi/sdk/payment_checkout_stable.min.js"></script>

<script>
  
  //console.warn("========== Init Payment Method ===============")
  
  let paymentCheckout = new PaymentCheckout.modal({
    client_app_code: '{{$config->clientAppCode}}',
    client_app_key: '{{$config->clientAppKey}}',
    locale: '{{$config->locale}}',
    env_mode: '{{$config->envMode}}',
    onResponse: function (response) { 

      if(response.transaction){

        checkResponse(response.transaction)
        processResponse(response)

      }
      
      //console.log(response)
      //document.getElementById('response').innerHTML = JSON.stringify(response);

    }
  });

  let btnOpenCheckout = document.querySelector('.js-payment-checkout');
  btnOpenCheckout.addEventListener('click', function () {
    paymentCheckout.open({
      user_id: '{{$config->order->customer_id}}',
      user_email: '{{$config->order->email}}',
      order_description: '{{$config->description}}',
      order_amount: {{$config->order->total}},
      order_vat: 0,
      order_reference: '{{$config->order->id}}'
    });
  });

  window.addEventListener('popstate', function () {
    paymentCheckout.close();
  });

  /*
  * Check Response and Show Alert
  */
  function checkResponse(responsePaymentez){
    let msj = "";
    if(responsePaymentez.status=="success")
      msj = "Transacción Aprobada"
    if(responsePaymentez.status=="failure")
      msj = "Transacción Fallida"
    if(responsePaymentez.status=="pending")
      msj = "Transacción Pendiente"

    alert(msj)
  }

  /*
  * API - Process Response
  */
  async function processResponse(responsePaymentez){

    $("#btnPay").hide();
    $("#loadingPayment").show();

    let url = "{{route('icommercepaymentez.api.paymentez.response')}}"

    // FETCH
    let responseProcess = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(responsePaymentez)
    });

    let result = await responseProcess.json();

    $("#loadingPayment").hide();

    // CHECK RESULT
    if(result){
      //console.warn(result.status)
      finishedPayment()

    }
  }

  /*
  * Reedirect to Order
  */
  function finishedPayment(){
      
      $('#dialogTitle').text("Reedireccionando...");
      $("#loadingPayment .alert").removeClass("alert-warning");
      $("#loadingPayment .alert").addClass("alert-success");

      $("#loadingPayment").show();

      let redirect = "{{$config->reedirectAfterPayment}}";
      window.location.href = redirect;
      
  }

</script>



@stop