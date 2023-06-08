@extends('layouts.master')

@section('title')
  Stripe | @parent
@stop


@section('content')
<div class="icommerce_stripe icommerce_stripe_index py-5">
    <div class="container">
  
     <div class="row my-5 py-5 justify-content-center">

      <div class="card text-center">
        <h5 class="card-header bg-primary text-white">Stripe- Bienvenido</h5>
        <div class="card-body">
          
         

          this is the body

         
          
        </div>
      </div>
 
      
 
     </div>
  
    </div>
</div>
@stop

@section('scripts')
@parent

<script>
  
  console.warn("hello muggle")

</script>



@stop