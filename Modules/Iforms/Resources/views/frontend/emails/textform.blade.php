@php
    $form=$lead['form'];
    $data=$lead['lead'];

@endphp

{{ $form->title }}

@foreach($data->values as $index => $field)
    {{ $index }}:{{ $field }}

@endforeach
