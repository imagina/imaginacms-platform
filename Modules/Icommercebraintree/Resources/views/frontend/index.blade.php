@extends('layouts.master')

@section('title')
  Braintree | @parent
@stop


@section('content')
<div class="icommerce_braintree icommerce_braintree_index py-5">
    <div class="container">
  
     <div class="row my-5 py-5 justify-content-center">

      <div class="card text-center">
        <h5 class="card-header bg-primary text-white">Braintree - Bienvenido</h5>
        <div class="card-body">
          
          {{-- ORDER INFOR --}}
          <div class="order-infor">
            <table class="table">
              <tbody>

                <tr>
                  <th scope="row">Email:</th>
                  <td>{{$order->email}}</td>
                </tr>

                <tr>
                  <th scope="row">Order ID:</th>
                  <td>{{$order->id}}</td>
                </tr>

                <tr>
                  <th scope="row">Total:</th>
                  <td>{{$order->total}}</td>
                </tr>
               

              </tbody>
            </table>
          </div>

          {{-- PAYMENT --}}
          <form method="post" id="payment-form" action="#">
                <section>
                    <div class="bt-drop-in-wrapper">
                        <div id="bt-dropin"></div>
                    </div>
                </section>
                <button id="btnPay" class="button" type="submit"><span>PAGAR</span></button>
          </form>

          {{-- LOADING --}}
          <div id="loadingPayment" class="my-3" style="display:none">
            <div class="alert alert-warning" role="alert">
              Realizando Proceso de Pago - Espere ...
            </div>
          </div>
          
        </div>
      </div>
 
      
 
     </div>
  
    </div>
</div>
@stop

@section('scripts')
@parent

<script src="https://js.braintreegateway.com/web/dropin/1.30.1/js/dropin.min.js"></script>

<script>
  
  var form = document.querySelector('#payment-form');
  var client_token = "{{$tokenBraintree}}";

  braintree.dropin.create({
          authorization: client_token,
          selector: '#bt-dropin',
          paypal: {
            flow: 'vault'
          }
  }, function (createErr, instance) {
    
    if (createErr) {
      console.log('Create Error', createErr);
      return;
    }

    form.addEventListener('submit', function (event) {
      
      event.preventDefault();

      // Get Payload
      instance.requestPaymentMethod(function (err, payload) {
        if (err) {
          alert(err)
          console.log('Request Payment Method Error', err);
          return;
        }

        processPayment(payload.nonce,{{$order->id}})

      });

    });

  });

  /*
  * API - Process Payment
  */
  async function processPayment(nonce,orderId){

    $("#btnPay").hide();
    $("#loadingPayment").show();

    let url = "{{route('icommercebraintree.api.braintree.processPayment')}}"
    
    let data = {
        orderId:{{$order->id}},
        clientNonce: nonce
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
      let data = result.data;
      if(data.success){
        console.warn(data.transaction)
        alert("PROCESO EXITOSO")

        finishedPayment()

      }else{
        console.warn(data)
        $("#btnPay").show();
        alert("ERROR EN EL PROCESO")
      }
    }

   
  }

  /*
  * Reedirect to Order
  */
  function finishedPayment(){
      
      let redirect = "{{$order->url}}"; 

      window.location.href = redirect;
      /*
      setTimeout(function () {
        window.location.href = redirect;
      }, 5000);
      */ 
  }

</script>



@stop