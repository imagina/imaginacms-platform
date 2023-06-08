@extends('layouts.master')

@section('title')
  ePayCo | @parent
@stop


@section('content')
<div class="icommerce_epayco icommerce_epayco_index py-5">
    <div class="container">
  
     <div class="row my-5 py-5 justify-content-center">

      <div class="card text-center">
        <h5 class="card-header bg-primary text-white">ePayco - Bienvenido</h5>
        <div class="card-body">
          <p class="card-text">Haz click en el botón para iniciar el proceso de pago</p>
         
          <form>
            <script
                  src="{{$config->url}}"
                  class="epayco-button"
                  data-epayco-key="{{$config->publicKey}}"
                  data-epayco-amount="{{$config->amount}}"
                  data-epayco-name="{{$config->name}}"
                  data-epayco-description="{{$config->description}}"
                  data-epayco-currency="{{$config->currency}}"
                  data-epayco-country="{{$config->country}}"
                  data-epayco-test="{{$config->test}}"
                  data-epayco-external="{{$config->external ? 'true':'false'}}"
                  data-epayco-response="{{$config->responseUrl}}"
                  data-epayco-confirmation="{{$config->confirmationUrl}}"
                  data-epayco-invoice="{{$config->invoice}}"
                  data-epayco-extra1="{{$config->extra1}}"
                  data-epayco-autoclick="{{$config->autoClick ? 'true':'false'}}">
            </script>
          </form>
          
        </div>
      </div>
 
      
 
     </div>
  
    </div>
</div>
@stop