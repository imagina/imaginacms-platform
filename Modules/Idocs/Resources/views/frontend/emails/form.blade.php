@extends(View::exists('email.plantilla')?'email.plantilla':'iforms::frontend.emails.mainlayout')

@section('content')
  <div id="contend-mail" class="p-3">
    <h1>{{$document->title }}</h1>
    <br>
    <div style="margin-bottom: 5px">
      {!! Setting::get('idocs::msg-email')!!}
      @if(count($document->users))
      @else
      <p>{{trans('idocs::documents.form.document')}}: {{$document->user_identification}}</p>
      <p>{{trans('idocs::documents.form.key')}}: {{$document->key}} </p>
      @endif
    </div>
  </div>
@stop