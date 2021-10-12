@if($captchaEnabled && $captchaEnabled == '1')
    {!! app('icaptcha')->display($params) !!}
    @once
        @section('scripts-owl')
             @parent
            <script type="text/javascript" src="https://www.google.com/recaptcha/api.js" async></script>
        @endsection
    @endonce
    @section('scripts-owl')
        @parent
        <script type="text/javascript">
          $(function(){
            disable{{ $formId }}Button();
          });
          function enable{{ $formId }}Button(response){
            if(response)
              $("#{{ $formId }} input[type=submit], #{{ $formId }} button[type=submit]").removeAttr('disabled');
          }
          function disable{{ $formId }}Button(){
            $("#{{ $formId }} input[type=submit], #{{ $formId }} button[type=submit]").attr('disabled','disabled');
          }
        </script>
    @stop
@endif
