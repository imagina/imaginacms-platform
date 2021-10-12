<button id="{{ $containerId }}DownloadButton" onclick="printContent('{{ $containerId }}')" class="btn btn-primary" title="{{ $text }} (Ctrl+P)">
    <i class="{{ $icon }}"></i> {{ $text  }}
</button>
@once
@section('scripts-owl')
  @parent
  <script type="text/javascript">
    function printContent(containerId){
      var restorepage = document.body.innerHTML;
      var printcontent = document.getElementById(containerId).innerHTML;
      var printHeader = '{!! Theme::style('css/secondary.css?v='.config('app.version')) !!}\n'
      document.body.innerHTML = printHeader + printcontent;
      window.print();
      document.body.innerHTML = restorepage;
    }
  </script>
@stop
@endonce
