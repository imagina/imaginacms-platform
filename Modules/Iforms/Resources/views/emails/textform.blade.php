@php
  $form=$data['form'];
  $lead=$data['lead'];
  $fields = $form->fields;
@endphp
<h1 style="font-size: 22px">{!! $data["title"] !!}</h1>
<p style="font-size: 16px">
  {!! $data["message"]!!}
</p>

<table style="width: 100%;border-collapse: collapse;">
  <tbody>
  @foreach($fields as $field)
    <tr>
      <th style="background-color: #eee;">{{ $field->label }}</th>
      @if($field->type == 12)
        <td>{{ url($lead->values[$field->name] ?? "") }}</td>
      @else
      <td>{{ $lead->values[$field->name] ?? "" }}</td>
      @endif
    </tr>
  @endforeach


  </tbody>
</table>
<br>
