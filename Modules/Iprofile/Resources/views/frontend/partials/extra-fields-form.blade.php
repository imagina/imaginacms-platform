@php

  $registerExtraFields = json_decode(setting('iprofile::registerExtraFields', null, "[]"));
  $fields = isset($fields) ? collect($fields)->keyBy('name') : [];

@endphp

@foreach($registerExtraFields as $extraField)
  @php($oldValue = isset($fields[$extraField->field]) ? $fields[$extraField->field]->value : null)
  {{-- if is active--}}
  @if(isset($extraField->active) && $extraField->active)

    {{-- form group--}}
    <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} py-2 has-feedback {{ $errors->has($extraField->field) ? ' has-error' : '' }}">

      {{-- label --}}
      <label for="extraField{{$extraField->field}}">
        @if(isset($extraField->label))
          {{$extraField->label}}
        @else
          {{trans("iprofile::frontend.form.$extraField->field")}}
        @endif
      </label>

      {{-- Generic input --}}
      @if( !in_array($extraField->type, ["select","textarea"]) )

        {{-- Text input --}}
        @if(in_array($extraField->type ,["text","number","checkbox","password","date"]))
          <input  type="{{$extraField->type}}" name="fields[{{$extraField->field}}]" {{$extraField->required ? 'required' : ''}} class ="form-control" id = 'extraField{{$extraField->field}}' value="{{$oldValue }}"/>
        @endif



        {{-- Custom documentType input --}}
        @if($extraField->type == "documentType")

          {{-- foreach options --}}
          @if(isset($extraField->availableOptions) && is_array($extraField->availableOptions) && count($extraField->availableOptions))
            @if(isset($extraField->availableOptions) && isset($extraField->options))
              @php($optionValues = [])
              @foreach($extraField->availableOptions as $availableOption)
                {{-- finding if the availableOption exist in the options and get the full option object --}}
                @foreach ($extraField->options as $option)
                  @if($option->value == $availableOption)
                    @php($optionValues = array_merge($optionValues, [ $option->value => $option->label]))
                  @endif
                @endforeach
              @endforeach
            @endif
          @else
            @php($optionValues = [])
            @foreach ($extraField->options as $option)
                @php($optionValues = array_merge($optionValues, [ $option->value => $option->label]))
            @endforeach
          @endif
          @if(isset($optionValues))
            {{-- Select --}}
            {{Form::select("fields[$extraField->field]", $optionValues, $oldValue, ['id'=>'extraField'.$extraField->field, 'required'=>$extraField->required,'class'=>"form-control",'placeholder' => ''] ) }}
          @endif
    </div>

    <div class="col-sm-12 {{isset($embedded) ? '' : 'col-md-6' }} py-2 has-feedback {{ $errors->has($extraField->field) ? ' has-error' : '' }}">
      <label for="extraFieldDocumentNumber">{{trans("iprofile::frontend.form.documentNumber")}}</label>

      @php($oldValue = isset($fields['documentNumber']->value) ? $fields['documentNumber']->value : null)
      <input  type="number" minlength="6" min="100000" max="9999999999" name="fields[documentNumber]" {{$extraField->required ? 'required' : ''}} class="form-control" id="extraFieldDocumentNumber" value="{{$oldValue}}"/>

      @endif

      @else
        {{-- if is select --}}
        @if($extraField->type == "select")

          {{-- foreach options --}}
          @if(isset($extraField->availableOptions) && is_array($extraField->availableOptions) && count($extraField->availableOptions))
            @if(isset($extraField->availableOptions) && isset($extraField->options))
              @php($optionValues = [])
              @foreach($extraField->availableOptions as $availableOption)
                {{-- finding if the availableOption exist in the options and get the full option object --}}
                @foreach ($extraField->options as $option)
                  @if($option->value == $availableOption)
                    @php($optionValues = array_merge($optionValues, [ $option->value => $option->label]))
                  @endif
                @endforeach
              @endforeach
            @endif
          @else
            @php($optionValues = [])
            @foreach ($extraField->options as $option)
              @php($optionValues = array_merge($optionValues, [ $option->value => $option->label]))
            @endforeach
          @endif
          @if(isset($optionValues))
            {{-- Select --}}
            {{Form::select("fields[$extraField->field]", $optionValues, $oldValue, ['id'=>'extraField'.$extraField->field, 'required'=>$extraField->required,'class'=>"form-control",'placeholder' => '']) }}
          @endif
        @else
          {{-- if is textarea --}}
          @if($extraField->type == "textarea")
            {{-- Textarea --}}
            {{ Form::textarea("fields[$extraField->field]", $oldValue, ['id'=>'extraField'.$extraField->field,'required'=>$extraField->required,'class'=>"form-control",'placeholder' => '', "cols" => 30, "rows" => 3])}}

          @endif {{--- end if is textarea --}}
        @endif {{-- end if is select --}}
      @endif {{-- end if is generic input --}}
    </div>
  @endif {{-- end if is active --}}
@endforeach
