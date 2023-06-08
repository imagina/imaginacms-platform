@extends($data["layout"] ?? setting('notification::templateEmail'))

@section('content')

  @if(isset($data["content"]) && $data["content"])
    @include($data["content"])
  @else
    <h1 class="email-title">
      {!! $data["title"] !!}
    </h1>
    <p class="email-message">
      {!! $data["message"]!!}
    </p>
  @endif

  @if(isset($data["withButton"]) && $data["withButton"])
    <p style="text-align: center;margin-top: 40px;">
      <a class="email-bottom" href='{{$data["link"]}}'>
        {!! $data["buttonText"] ?? trans("isite::common.menu.viewMore")!!}
      </a>
    </p>
  @endif
@stop