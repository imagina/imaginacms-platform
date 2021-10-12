@section('scripts-owl')
  @parent
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
  <script type="text/javascript" defer>

    $(document).ready(function () {
      var formId = '#{{$formId}}';
      $(formId).submit(function (event) {
        event.preventDefault();
        var livewireSubmitEvent = '{{ $livewireSubmitEvent ?? '' }}';
        if (livewireSubmitEvent != '') {
          window.livewire.emit(livewireSubmitEvent, info);
        } else {
          var formdata =objectifyForm(formId)

          $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            processData: false,
            contentType: false,
            data: formdata,
            beforeSend: function (data) {
              $('#loading-form').css('display', 'block');
            },
            success: function (data) {
              $('#loading-form').css('display', 'none');
              $(".content-form{{$formId}}").html('<p class="alert bg-primary" role="alert"><span>' + data.data + '</span> </p>');

            },
            error: function (data) {
              $('#loading-form').css('display', 'none');
              var errors = JSON.parse(data.responseJSON.errors);
              for (var x in errors) {
                $(".content-form{{$formId}} .formerror").append('<p class="alert alert-danger" role="alert"><span>' + errors[x] + '</span> </p>');
              }

            }
          });
        }
      });
    });
  </script>
@endsection
@once
@section('scripts-owl')
  @parent
  <script type="text/javascript" defer>
    function objectifyForm(formId) {//serialize data function

      var data = new FormData();

//Form data
      var form_data = $(formId).serializeArray();
      $.each(form_data, function (key, input) {
        data.append(input.name, input.value);
      });

//File data
      var files = $(formId+' input[type="file"]');

      for (var i = 0; i < files.length; i++) {
        inputFile = files[i].files[0]
        data.append(files[i].name,inputFile);
      }

      return data;
    }
  </script>
@stop
@endonce
