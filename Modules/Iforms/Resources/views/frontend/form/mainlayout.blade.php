@section('scripts-owl')
  @parent
  <script src="https://www.google.com/recaptcha/api.js"></script>
  <style>
    #loading-form {
      display: none;
      position: absolute;
      background-color: rgba(0, 0, 0, 0.6);
      z-index: 1000000;
      width: 100%;
      height: 100%;
    }

    .lds-spinner {
      color: #fff;
      display: block;
      position: relative;
      width: 64px;
      height: 64px;
      margin: auto;
      background: #fff;
      top: 50%;
    }
  </style>
  <script>

      $(document).ready(function () {
          var formid = '#{{$id}}';
          $(formid).submit(function (event) {
              event.preventDefault();
              var info = objectifyForm($(this).serializeArray());
              //console.warn(info);
              info.captcha = {'version': '2', 'token': info['g-recaptcha-response']};
              delete info['g-recaptcha-response'];
              $.ajax({
                  type: 'POST',
                  url: $(this).attr('action'),
                  dataType: 'json',
                  data: {attributes: info},
                  beforeSend: function (data) {
                      $('#loading-form').css('display', 'block');
                  },
                  success: function (data) {
                      $('#loading-form').css('display', 'none');
                      $(".content-form{{$options['rand']}}").html('<p class="alert bg-primary" role="alert"><span>' + data.data + '</span> </p>');

                  },
                  error: function (data) {
                      $('#loading-form').css('display', 'none');
                      $(".content-form{{$options['rand']}} .formerror").append('<p class="alert alert-danger" role="alert"><span>' + data.responseJSON.errors + '</span> </p>');
                  }
              })
          })
      });

      function objectifyForm(formArray) {//serialize data function

          var returnArray = {};


          for (var i = 0; i < formArray.length; i++) {
              var $obj = $("[name='"+formArray[i]['name']+"'] option:selected");
              var $val = []
              if($obj.length>0) {
                $obj.each(function() {
                  $val.push($(this).val());
                });
                returnArray[formArray[i]['name']] = $val.join(', ');
              }else{
                returnArray[formArray[i]['name']] = formArray[i]['value'];
              }
          }
          return returnArray;
      }


  </script>
@endsection
