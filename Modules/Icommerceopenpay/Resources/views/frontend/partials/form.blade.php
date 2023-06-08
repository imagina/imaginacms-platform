<form action="#" method="POST" id="payment-form" style="display:none">
   <input type="hidden" name="token_id" id="token_id">

    <div class="card">

      <div class="card-header font-weight-bold text-uppercase">
        Tarjeta de Credito o Debito
      </div>

      <div class="card-body">

        <div class="d-flex flex-row mb-3">
            <div class="tj-cred">
              <h6>Tarjetas de crédito</h6> 
              <x-media::single-image src="{{url('modules/icommerceopenpay/img/cards1.png')}}" />
            </div>
            <div class="tj-deb px-5">
               <h6>Tarjetas de débito</h6>
              <x-media::single-image src="{{url('modules/icommerceopenpay/img/cards2.png')}}" />
            </div>
        </div>

        <div class="form-row">
           <div class="form-group col-md-6">
              <label >Nombre del titular</label>
              <input type="text" class="form-control" placeholder="Como aparece en la tarjeta" autocomplete="off" data-openpay-card="holder_name">
            </div>
            <div class="form-group col-md-6">
              <label>Número de tarjeta</label>
              <input type="text" class="form-control" autocomplete="off" data-openpay-card="card_number">
            </div>
        </div>

        <div class="form-row">
           
            <div class="form-group col-md-6">
              {{--
              <label>Fecha de expiración</label>
              --}}
              <div class="row">
                <div class="col-xs-12 col-md-6">
                  {{--
                  <input type="text" class="form-control" placeholder="Mes" data-openpay-card="expiration_month">
                  --}}
                  <label>Mes</label>
                  <select class="custom-select" data-openpay-card="expiration_month">
                    <option value="01" selected>01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                  </select>
                </div>
                <div class="col-xs-12 col-md-6">
                  <label>Año (Ejm: 21,22)</label>
                  <input type="number" min="21" max="30" class="form-control" placeholder="2 digitos" data-openpay-card="expiration_year">
                </div>
              </div>
            </div>
            <div class="form-group col-md-3">
              <label>Código de seguridad</label>
              <input type="text" class="form-control" placeholder="3 dígitos" autocomplete="off" data-openpay-card="cvv2">
            </div>
            <div class="form-group col-md-3 d-flex align-items-center">
              <x-media::single-image src="{{url('modules/icommerceopenpay/img/cvv.png')}}" />
            </div>

        </div>
       
        <div class="d-flex justify-content-between mt-1">
            <div class="logo">Transacciones realizadas vía:
              <x-media::single-image src="{{url('modules/icommerceopenpay/img/openpay.png')}}" />
            </div>
                        
            <div class="shield">
              <x-media::single-image src="{{url('modules/icommerceopenpay/img/security.png')}}" />
              Tus pagos se realizan de forma segura con encriptación de 256 bits
            </div>
        </div>
       

        <div class="d-flex justify-content-end">
          <a id="pay-button" class="btn btn-primary cursor-pointer btn-pay">Pagar: {{formatMoney($config->order->total)}}</a>
        </div>

        

      </div>
    </div>
</form>