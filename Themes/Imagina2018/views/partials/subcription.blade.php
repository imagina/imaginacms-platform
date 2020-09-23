
<div class="container">
    <div class="row text-white">
        <div class="col-12 col-md-3">
        </div>
        <div class="col-12 col-md-7">
            <h4 class="text1-suscribe-footer mb-0">
                SUSCRÍBETE A TIENDA RENOVAR
            </h4>
            <h5 class="text2-suscribe-footer mb-4">
                Suscríbete a nuestro boletín para obtener las últimas novedades sobre <br> nuestros productos y promociones.
            </h5>
            <form id="suscripcion" method="post" action="{{route('api.iforms.leads.create')}}">
                <input type="hidden" name="form_id" value="2" required="">
                <div class="input-group border border-white rounded">
                    <input type="text" class="border-0 bg-transparent text3-suscribe-footer"
                            placeholder="Tu email..." name="email" required
                            aria-label="Tu email..." >
                        <button class="btn btn-light text-primary rounded" type="submit">
                            SUSCRÍBETE
                        </button>
                    
                </div>
                <div class="pt-3">
                    {!!app('captcha')->display($attributes = ['data-sitekey'=>Setting::get('iforms::api')])!!}
                    <br>
                </div>
            </form>
            <div class="formerror"></div>
        </div>
        <div class="col-12 col-md-1">
        </div>
    </div>
</div>
@section('scripts')
    @parent
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>

        $(document).ready(function () {
            var formid = '#suscripcion';
            $(formid).submit(function (event) {
                event.preventDefault();
                var info = objectifyForm($(this).serializeArray());

                info.captcha = {'version': '2', 'token': info['g-recaptcha-response']};
                delete info['g-recaptcha-response'];
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    dataType: 'json',
                    data: {attributes: info},
                    success: function (data) {
                        $(".boletin").html('<p class="alert bg-primary text-white mb-0" role="alert"><span>' + data.data + '</span> </p>');
                    },
                    error: function (data) {
                        $(".boletin .formerror").append('<p class="alert alert-danger mb-0 mt-3" role="alert"><span>' + data.responseJSON.errors + '</span> </p>');
                    }
                })
            })
        });

        function objectifyForm(formArray) {//serialize data function

            var returnArray = {};
            for (var i = 0; i < formArray.length; i++) {
                returnArray[formArray[i]['name']] = formArray[i]['value'];
            }
            return returnArray;
        }
    </script>

@stop
