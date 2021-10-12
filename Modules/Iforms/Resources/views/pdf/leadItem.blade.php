@php
    $lead=$items->first();
    $form=$lead->form;
    $blocks=$form->blocks;

@endphp
@if(isset($form->options->customLeadPDFTemplate) && !empty(isset($form->options->customLeadPDFTemplate)))

    @include($form->options->customLeadPDFTemplate,["form" => $form, "lead" => $lead, "blocks" => $blocks])

@else

    <h1 style="font-size: 16px">Formulario: {{ $form->title }}</h1>
    <h5 style="margin: 0 10px 10px 0;">Registro #{{$lead->id}}</h5>
    @if(isset($lead->assignedTo->id))
        <p style="font-size: 10px">
            Asignado a: {{ $lead->assignedTo->present()->fullname }}
        </p>
    @endif

    @foreach($blocks as $block)
        <hr style="color: #eee; margin: 5px">
        @if(!empty($block->title))
            <h5 style="margin: 0 10px 10px 0;">{{$block->title}}</h5>
        @endif
        @if(!empty($block->description))
            <p>{{$block->description}}</p>
        @endif
        <table style="border: 1px solid #ebebeb;
    padding: 20px;
    width: 80%;
    border-radius: 1em;
    overflow: hidden;
    text-align: center;
    margin: 0 auto;
    margin-bottom:20px">
            <tbody>
            @foreach($block->fields as $blockField)
                <tr>
                    <th style="font-size: 12px; color:#333333; text-align: left">{{ $blockField->label }}</th>
                    <td style="font-size: 12px; text-align: left">{{ $lead->values[$blockField->name] ?? '' }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>

    @endforeach

    <br>

@endif