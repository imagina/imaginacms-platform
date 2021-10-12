@php
    $form=$data['form'];
    $lead=$data['lead'];

@endphp
<h1 style="font-size: 22px">{!! $data["title"] !!}</h1>
<p style="font-size: 16px">
    {!! $data["message"]!!}
</p>

<table style="width: 100%;border-collapse: collapse;">
    <tbody>
@foreach($lead->values as $index => $field)
    <tr>
    <th style="background-color: #eee;">{{ $index }}</th> <td>{{ $field }}</td>
    </tr>
@endforeach

    </tbody>
</table>
<br>
