@extends($data["layout"] ?? 'notification::emails.layouts.default')

@section('content')

  @if(isset($data["content"]) && $data["content"])
    @include($data["content"])
    @else
      <h1 style="font-size: 22px">{!! $data["title"] !!}</h1>
      <p style="font-size: 16px; margin-bottom: 15px">
        {!! $data["message"]!!}
      </p>
  @endif
  @if(isset($data["withButton"]) && $data["withButton"])
    <div>
      <a href='{{$data["link"]}}'
         style="text-decoration: none;
           background-color: {{Setting::get('isite::brandSecondary')}};
           padding: 10px;
           margin: 10px 10px;
           color: white;"
         target="_blank">{!! $data["buttonText"] ?? trans("isite::common.menu.viewMore")!!}</a>
    </div>
  @endif
@stop
