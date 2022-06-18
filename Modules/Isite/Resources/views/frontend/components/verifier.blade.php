
@php
    function verifierSanitizeOutput($buffer) {

      $search = array(
          '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
          '/[^\S ]+\</s',     // strip whitespaces before tags, except space
          '/(\s)+/s',         // shorten multiple whitespace sequences
          '/<!--(.|\s)*?-->/' // Remove HTML comments
      );

      $replace = array(
          '>',
          '<',
          '\\1',
          ''
      );

      $buffer = preg_replace($search, $replace, $buffer);

      return $buffer;
  }

    $statusCheckoutModal = json_decode(setting("isite::statusModalVerifier", null, "0"));
@endphp

@section('scripts-owl')
@parent

<script defer >
  function verifierSetCookie(name,value,days) {
    var expires = "";
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days*24*60*60*1000));
      expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
  }
  function verifierGetCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
  }

  // document.addEventListener('DOMContentLoaded', function () {
  verifier = verifierGetCookie("verifier");

  if(!verifier){
    Swal.fire({
      title: '<strong>@setting("isite::titleModalVerifier")</strong>',
      html: '{!! verifierSanitizeOutput(setting('isite::contentModalVerifier')) !!}',
      icon: 'alert',
      confirmButtonText: '@setting("isite::buttonLabelModalVerifier")',
      allowOutsideClick: false,
      allowEscapeKey: false,
    }).then((result) => {
      if (result.isConfirmed) {
        verifierSetCookie("verifier","ok",30)
      }
    })
  }


  // });

</script>

@stop

