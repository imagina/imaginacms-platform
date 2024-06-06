@extends(View::exists('email.plantilla')?'email.plantilla':'iforms::frontend.emails.mainlayout')
@php
$form=$lead['form'];
$data=$lead['lead'];

  @endphp


@section('content')
  <div id="contend-mail" class="p-3">
    <h1>{{ $form->title }}</h1>
    <br>
    <div style="margin-bottom: 5px">
      @foreach($data->values as $index => $field)
        <p class="px-3"><strong>{{ $index }}:</strong> {{ $field }} </p>
      @endforeach
    </div>
  </div>
@stop