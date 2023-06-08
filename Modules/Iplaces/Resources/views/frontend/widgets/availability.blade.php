<div class="card card-availability border border-gray-lighter ">
    <div class="card-body text-gray-dark text-center p-0">
        <h5 class="card-title text-primary mb-3">Consultar Disponibilidad</h5>

        <div class="content-availability">

            {!!Form::open(array('url' => url("/iforms/lead"), 'method' => 'POST', 'id' => 'availability'))!!}
            <input type="hidden" name="form_id" value="7" required="">


            <input type="hidden" name="lugar" value="{{$place->title}}">


            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="nombre1"><i class="fa fa-user"></i></span>
                </div>
                {{Form::text('nombre',null,['class'=>'form-control pl-0','required' => 'required','placeholder'=>'Nombre', 'aria-label'=>'Nombre', 'aria-describedby'=>'nombre1'])}}
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="email1"><i class="fa fa-envelope"></i></span>
                </div>
                {{Form::email('email',null,['class'=>'form-control pl-0','required' => 'required','placeholder'=>'Email', 'aria-label'=>'Email', 'aria-describedby'=>'email1'])}}
            </div>

            <div class="row no-gutters">
                <div class="col-3">
                    {{Form::text('codigo',null,['class'=>'form-control  border-r-p','required' => 'required','placeholder'=>'+57'])}}
                </div>
                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend border-l-p">
                            <span class="input-group-text" id="telefono1"><i class="fa fa-phone"></i></span>
                        </div>
                        {{Form::text('telefono',null,['class'=>'form-control pl-0','required' => 'required','placeholder'=>'Teléfono', 'aria-label'=>'Teléfono', 'aria-describedby'=>'telefono1'])}}
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="fecha1"><i class="fa fa-calendar"></i></span>
                </div>
                {{Form::date('fecha',null,['class'=>'form-control pl-0','required' => 'required','placeholder'=>'dd/mm/aa', 'aria-label'=>'dd/mm/aa', 'aria-describedby'=>'fecha1'])}}
            </div>

            <div class="input-group mb-3 text-center">
                {{Form::textarea('mensaje',null,['class'=>'form-control textarea','placeholder'=>'Escribe tu solicitud a la empresa','size' => '1x2','required' => 'required'])}}
            </div>

            <div class="formerror"></div>

            <button type="submit" class="btn btn-rounded text-white bg-primary mt-1 mx-auto px-3 py-2">Enviar Solicitud</button>

            {!!Form::close()!!}

        </div>

        <hr>

        <p class="card-text mb-3">
            Haciendo click en Continuar acepto las
            Condiciones De Uso
        </p>




    </div>


</div>



@section('scripts-owl')
    <script>
        $(document).ready(function () {
            var formid = '#availability';
            $(formid).submit(function (event) {
                event.preventDefault();
                var $form = $(this).serializeArray(),
                    url = $(this).attr("action");
                var posting = $.post(url, $form);
                posting.done(function (response) {
                    var content = response.status;

                    if (content == "success") {
                        $(".content-availability").html('<div class="alert bg-primary text-white" role="alert"><span>Datos Enviados</span> </div>');
                    }
                    else if(content == "fail") {
                        $.each(response.data,function (index, value) {
                            $(".content-availability .formerror").append('<div class="alert alert-danger text-white" role="alert"><span>' + value + '</span> </div>');
                        });
                    }
                    else {
                        $(".content-availability .formerror").append('<div class="alert bg-primary text-white" role="alert"><span>' + response.message + '</span> </div>');
                    }

                });

            });
        });
    </script>

    @parent

@stop























