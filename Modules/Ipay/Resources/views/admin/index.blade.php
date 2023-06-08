@extends('layouts.master')
@section('header')

@endsection

@section('content')
<div class="row">

	<div class="col-md-8 col-md-offset-2">
       @foreach($errors->all() as $error)
            <div class="row">
                <br>
                <div class="col-md-12 text-center">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        {{$error}}
                    </div>
                </div>
            </div>
        @endforeach
        <br>
		<a href="{{ url('backend') }}">		
			<i class="fa fa-angle-double-left"></i> Volver al inicio
		</a>
		<br>
		<br>
		   {!! Form::open(['route' => ['admin.ipay.config.update'], 'method' => 'put']) !!}
			<div class="box">
				<div class="box-header with-border">
			      <h3 class="box-title">Editar boton de pago</h3>
			    </div>

			    <div class="box-body row">
			    	<div class="form-group col-md-12">
    					<label>Habilitar/Deshabilitar</label>
    					<div class="row icheckbox-inline">
							<div class="col-sm-12">
								<input type="checkbox" class="styled" name="status" {{ ($status) ? 'checked' : '' }} value="1">
							</div>
    					</div>
			    	</div>
			    	<div class="form-group col-md-12">
    					<label>Título</label>
                    	<input type="text" name="title" value="{{ $title }}" class="form-control" required="" maxlength="255">
    				</div>
    				<div class="form-group col-md-12">
    					<label>Merchant ID</label>
                    	<input type="number" name="merchantid" value="{{ $merchantid }}" class="form-control" required="">
    				</div>
    				<div class="form-group col-md-12">
    					<label>Account ID</label>
                    	<input type="number" name="accountid" value="{{ $accountid }}" class="form-control" required="">
    				</div>
    				<div class="form-group col-md-12">
    					<label>API Key</label>
                    	<input type="text" name="apikey" value="{{ $apikey }}" class="form-control" maxlength="255" required="">
    				</div>
    				<div class="form-group col-md-12">
    					<label>Transacciones en modo de prueba</label>
    					<div class="row icheckbox-inline">
							<div class="col-sm-12">
                    			<input type="checkbox" class="styled" name="mode" {{ ($mode) ? 'checked' : '' }} value="1">
                    		</div>
                    	</div>
    				</div>
                    <div class="form-group col-md-12">
                        <label>currency</label>
                        <div class="row icheckbox-inline">
                            <div class="col-sm-12">
                                <select class="form-control" name="currency" required="">
                                    <option value="USD" {{ ($currency == 'USD') ? 'selected' : '' }} >USD</option>
                                    <option value="COP" {{ ($currency == 'COP') ? 'selected' : '' }} >COP</option>
                                    <option value="MXN" {{ ($currency == 'MXN') ? 'selected' : '' }} >MXN</option>
                                    <option value="ARS" {{ ($currency == 'ARS') ? 'selected' : '' }} >ARS</option>
                                    <option value="PEN" {{ ($currency == 'PEN') ? 'selected' : '' }} >PEN</option>
                                    <option value="BRL" {{ ($currency == 'BRL') ? 'selected' : '' }} >BRL</option>
                                    <option value="CLP" {{ ($currency == 'CLP') ? 'selected' : '' }} >CLP</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
    				<div class="form-group col-md-12">
    					<label>Página de respuesta</label>
                    	<input type="url" name="replyurl" value="{{ $replyurl }}" class="form-control" maxlength="255">
    				</div>
    				<div class="form-group col-md-12">
    					<label>Página de confirmación</label>
                    	<input type="url" name="confirmationurl" value="{{ $confirmationurl }}" class="form-control" maxlength="255">
    				</div>
			    </div>

			    <div class="box-footer">
				  	<button type="submit" class="btn btn-success ladda-button" data-style="zoom-in">
				  		<span class="ladda-label"><i class="fa fa-save"></i> Actualizar</span>
				  	</button>
		      		<a href="{{ url('backend/') }}" class="btn btn-default ladda-button" data-style="zoom-in">
		      			<span class="ladda-label">Cancelar</span>
		      		</a>
		    	</div>
			</div>
		   {!! Form::close() !!}
	</div>	  
</div>
@endsection