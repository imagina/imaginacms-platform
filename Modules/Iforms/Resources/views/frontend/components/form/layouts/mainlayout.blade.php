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
        var formdata = objectifyForm(formId)
        var jsSubmitEvent = '{{ $jsSubmitEvent ?? '' }}';

        if (jsSubmitEvent != '') {
          console.warn("jsSubmitEvent",jsSubmitEvent)
          console.warn(window.dispatchEvent(new CustomEvent(jsSubmitEvent, {})))
        }

        var livewireSubmitEvent = '{{ $livewireSubmitEvent ?? '' }}';

        if (livewireSubmitEvent != '') {
          window.livewire.emit(livewireSubmitEvent, livewireObjectifyForm($(this).serializeArray()));
        } else {

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
      var files = $(formId + ' input[type="file"]');

      for (var i = 0; i < files.length; i++) {
        inputFile = files[i].files[0]
        data.append(files[i].name, inputFile);
      }

      return data;
    }

    function livewireObjectifyForm(formArray) {//serialize data function

      var returnArray = {};


      for (var i = 0; i < formArray.length; i++) {
        var $obj = $("[name='" + formArray[i]['name'] + "'] option:selected");
        var $val = []
        if ($obj.length > 0) {
          $obj.each(function () {
            $val.push($(this).val());
          });
          returnArray[formArray[i]['name']] = $val.join(', ');
        } else {
          returnArray[formArray[i]['name']] = formArray[i]['value'];
        }
      }
      return returnArray;
    }
  </script>
@stop
@endonce
