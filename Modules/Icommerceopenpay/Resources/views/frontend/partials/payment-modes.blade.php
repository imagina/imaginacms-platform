<div id="paymentModes" class="mt-4 mb-3">
	
	<label for="paymentMode">{{trans('icommerceopenpay::icommerceopenpays.form.select payment mode')}}:</label>
    <select class="form-control" id="selectPaymentMode">
        <option value="0">Seleccione</option>
        @foreach ($config->paymentModes as $mode)
            <option value="{{$mode->value}}">{{$mode->label}}</option>
        @endforeach
    </select>

</div>