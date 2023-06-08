@extends('layouts.master')

@section('title')
  Openpay | @parent
@stop


@section('content')
<div class="icommerce_openpay icommerce_openpay_index py-5">
    <div class="container">
  
     <div class="row my-5 py-5 justify-content-center">

      <div class="card text-center">
        <h5 class="card-header bg-primary text-white">Openpay - Bienvenido</h5>
        <div class="card-body">
          
            {{dd("EJEMPLO SOLO GENERAR TOKEN")}}
            
            <div id="resultDetail"></div>

            <form id="processCard" name="processCard">
                <p>Holder Name:</p><input data-openpay-card="holder_name" size="50" type="text">
                <p>Card number:</p><input data-openpay-card="card_number" size="50" type="text">
                <p>Expiration year:</p><input data-openpay-card="expiration_year" size="4" type="text">
                <p>Expiration month:</p><input data-openpay-card="expiration_month" size="4" type="text">
                <p>cvv2:</p><input data-openpay-card="cvv2" size="5" type="text">
                <p>Street:</p><input data-openpay-card-address="line1" size="20" type="text">
                <p>Number:</p><input data-openpay-card-address="line2" size="20" type="text">
                <p>References:</p><input data-openpay-card-address="line3" size="20" type="text">
                <p>Postal code:</p><input data-openpay-card-address="postal_code" size="6" type="text">
                <p>City:</p><input data-openpay-card-address="city" size="20" type="text">
                <p>State:</p><input data-openpay-card-address="state" size="20" type="text">
                <p>Country code:</p><input data-openpay-card-address="country_code" size="3" type="text">
                <input id="makeRequestCard" type="button" value="Make Card">
            </form>

          
        </div>
      </div>
 
      
 
     </div>
  
    </div>
</div>
@stop

@section('scripts')
@parent

<script type="text/javascript" src="https://resources.openpay.co/openpay.v1.min.js"></script> 

<script>
$(document).ready(function () {
  
  OpenPay.setId('{{$config->merchantId}}'); 
  OpenPay.setApiKey('{{$config->publicKey}}');
  OpenPay.setSandboxMode(true);

  // Event - Click BTN
  $( "#makeRequestCard" ).click(function() {
    OpenPay.token.extractFormAndCreate($('#processCard'),successCard,errorCard);
  });
  

  function successCard(response) {
   
    alert('Operación exitosa');
    console.warn(response)
   
    var content = '', results = document.getElementById('resultDetail');
    content += 'Id tarjeta: ' + response.data.id+ '<br/>';
    content += 'A nombre de: ' + response.data.card.holder_name + '<br/>';
    content += 'Marca de tarjeta usada: ' + response.data.card.brand + '<br/>';
    results.innerHTML = content;
    
  } 


  function errorCard(response) {
    
    alert('Fallo en la transacción');
    console.warn(response)
    
    var content = '', results = document.getElementById('resultDetail');

    content += 'Estatus del error: ' + response.data.status + '<br />';
    content += 'Error: ' + response.message + '<br />';
    content += 'Descripción: ' + response.data.description + '<br />';
    content += 'ID de la petición: ' + response.data.request_id + '<br />';
    results.innerHTML = content;
    
  }   

});
</script>



@stop