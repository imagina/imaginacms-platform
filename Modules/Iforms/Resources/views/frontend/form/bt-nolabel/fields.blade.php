<?php
$fields = $form->fields;
?>
{{ csrf_field() }}
<div class="form-group row">
    @foreach($fields as $field)
        <div class="col-sm-6 py-2">
        @switch($field->present()->type['value'])
            @case('text')
                @if(!empty($field->prefix) || !empty($field->suffix))
                    <div class="input-group flex-nowrap">
                        @if(!empty($field->prefix))
                            @if(!empty($field->prefix->type))
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0 text-primary">
                                        @if($field->prefix->type=='icon')
                                            <i class="text-primary {{ $field->prefix->value }}"></i>
                                        @else
                                            {{ $field->prefix->value }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                        @endif
                @endif
                <input type="text" class="form-control bg-transparent {{ !empty($field->prefix) ? !empty($field->prefix->type) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->type) ? 'border-right-0' : '' : '' }}" name="{{$field->name}}"
                       id="input{{$field->name}}" {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}">
                @if(!empty($field->prefix) || !empty($field->suffix))
                    @if(!empty($field->suffix))
                        @if(!empty($field->suffix->type))
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent border-left-0 text-primary">
                                    @if($field->suffix->type=='icon')
                                        <i class="text-primary {{ $field->suffix->value }}"></i>
                                    @else
                                        {{ $field->suffix->value }}
                                    @endif
                                </span>
                            </div>
                        @endif
                    @endif
                    </div>
                @endif
            @break

            @case('textarea')
            <div class="col-sm6">
                @if(!empty($field->prefix) || !empty($field->suffix))
                    <div class="input-group flex-nowrap">
                        @if(!empty($field->prefix))
                            @if(!empty($field->prefix->type))
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0 text-primary">
                                        @if($field->prefix->type=='icon')
                                            <i class="text-primary {{ $field->prefix->value }}"></i>
                                        @else
                                            {{ $field->prefix->value }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                        @endif
                @endif
                    <textarea class="form-control bg-transparent {{ !empty($field->prefix) ? !empty($field->prefix->type) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->type) ? 'border-right-0' : '' : '' }}" name="{{$field->name}}" placeholder="{{ $field->placeholder ?? '' }}"
                              rows="4"></textarea>
                @if(!empty($field->prefix) || !empty($field->suffix))
                    @if(!empty($field->suffix))
                        @if(!empty($field->suffix->type))
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent border-left-0 text-primary">
                                    @if($field->suffix->type=='icon')
                                        <i class="text-primary {{ $field->suffix->value }}"></i>
                                    @else
                                        {{ $field->suffix->value }}
                                    @endif
                                </span>
                            </div>
                        @endif
                    @endif
                    </div>
                @endif
            @break
            @case('number')
                @if(!empty($field->prefix) || !empty($field->suffix))
                    <div class="input-group flex-nowrap">
                        @if(!empty($field->prefix))
                            @if(!empty($field->prefix->type))
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0 text-primary">
                                        @if($field->prefix->type=='icon')
                                            <i class="text-primary {{ $field->prefix->value }}"></i>
                                        @else
                                            {{ $field->prefix->value }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                        @endif
                @endif
                    <input type="number" class="form-control bg-transparent {{ !empty($field->prefix) ? !empty($field->prefix->type) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->type) ? 'border-right-0' : '' : '' }}" name="{{$field->name}}"
                       id="input{{$field->name}}" {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}">
                @if(!empty($field->prefix) || !empty($field->suffix))
                    @if(!empty($field->suffix))
                        @if(!empty($field->suffix->type))
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent border-left-0 text-primary">
                                    @if($field->suffix->type=='icon')
                                        <i class="text-primary {{ $field->suffix->value }}"></i>
                                    @else
                                        {{ $field->suffix->value }}
                                    @endif
                                </span>
                            </div>
                        @endif
                    @endif
                    </div>
                @endif
            @break
            @case('email')
                @if(!empty($field->prefix) || !empty($field->suffix))
                    <div class="input-group flex-nowrap">
                        @if(!empty($field->prefix))
                            @if(!empty($field->prefix->type))
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0 text-primary">
                                        @if($field->prefix->type=='icon')
                                            <i class="text-primary {{ $field->prefix->value }}"></i>
                                        @else
                                            {{ $field->prefix->value }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                        @endif
                @endif
                    <input type="email" class="form-control bg-transparent {{ !empty($field->prefix) ? !empty($field->prefix->type) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->type) ? 'border-right-0' : '' : '' }}" name="{{$field->name}}"
                       id="input{{$field->name}}" {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}">
                @if(!empty($field->prefix) || !empty($field->suffix))
                    @if(!empty($field->suffix))
                        @if(!empty($field->suffix->type))
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent border-left-0 text-primary">
                                    @if($field->suffix->type=='icon')
                                        <i class="text-primary {{ $field->suffix->value }}"></i>
                                    @else
                                        {{ $field->suffix->value }}
                                    @endif
                                </span>
                            </div>
                        @endif
                    @endif
                    </div>
                @endif
            @break
            @case('select')
            @case('selectmultiple')
                @if(!empty($field->prefix) || !empty($field->suffix))
                    <div class="input-group flex-nowrap">
                        @if(!empty($field->prefix))
                            @if(!empty($field->prefix->type))
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0 text-primary">
                                        @if($field->prefix->type=='icon')
                                            <i class="text-primary {{ $field->prefix->value }}"></i>
                                        @else
                                            {{ $field->prefix->value }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                        @endif
                @endif
                @php
                    $options = json_decode($field->selectable)
                @endphp
                <select {{ $field->present()->type['value']=='selectmultiple'?'multiple':'' }} class="form-control bg-transparent {{ !empty($field->prefix) ? !empty($field->prefix->type) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->type) ? 'border-right-0' : '' : '' }}" name="{{$field->name}}"
                        id="input{{$field->name}}" {{$field->required?'required':''}}   data-placeholder="{{ $field->placeholder ?? '' }}"
                >
                    @foreach($options as $option)
                        <option value="{{ $option->name }}">{{ $option->name  }}</option>
                    @endforeach
                </select>
                @if(!empty($field->prefix) || !empty($field->suffix))
                    @if(!empty($field->suffix))
                        @if(!empty($field->suffix->type))
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent border-left-0 text-primary">
                                    @if($field->suffix->type=='icon')
                                        <i class="text-primary {{ $field->suffix->value }}"></i>
                                    @else
                                        {{ $field->suffix->value }}
                                    @endif
                                </span>
                            </div>
                        @endif
                    @endif
                    </div>
                @endif
            @break
            @case('radio')
                @php
                    $options = json_decode($field->selectable)
                @endphp
                @foreach($options as $option)
                    <label>
                        <input type="radio" name="{{$field->name}}" value="{{ $option->name }}"/>&nbsp; {{ $option->name  }} &nbsp;&nbsp;
                    </label>
                @endforeach
            @break
            @case('phone')
                @if(!empty($field->prefix) || !empty($field->suffix))
                    <div class="input-group flex-nowrap">
                        @if(!empty($field->prefix))
                            @if(!empty($field->prefix->type))
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0 text-primary">
                                        @if($field->prefix->type=='icon')
                                            <i class="text-primary {{ $field->prefix->value }}"></i>
                                        @else
                                            {{ $field->prefix->value }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                        @endif
                @endif
                    <input type="phone" class="form-control bg-transparent {{ !empty($field->prefix) ? !empty($field->prefix->type) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->type) ? 'border-right-0' : '' : '' }}" name="{{$field->name}}"
                       id="input{{$field->name}}" {{$field->required?'required':''}}   placeholder="{{ $field->placeholder ?? '' }}">
                @if(!empty($field->prefix) || !empty($field->suffix))
                    @if(!empty($field->suffix))
                        @if(!empty($field->suffix->type))
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent border-left-0 text-primary">
                                    @if($field->suffix->type=='icon')
                                        <i class="text-primary {{ $field->suffix->value }}"></i>
                                    @else
                                        {{ $field->suffix->value }}
                                    @endif
                                </span>
                            </div>
                        @endif
                    @endif
                    </div>
                @endif
            @break
            @case('date')
                @if(!empty($field->prefix) || !empty($field->suffix))
                    <div class="input-group flex-nowrap">
                        @if(!empty($field->prefix))
                            @if(!empty($field->prefix->type))
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-transparent border-right-0 text-primary">
                                        @if($field->prefix->type=='icon')
                                            <i class="text-primary {{ $field->prefix->value }}"></i>
                                        @else
                                            {{ $field->prefix->value }}
                                        @endif
                                    </span>
                                </div>
                            @endif
                        @endif
                @endif
                    <input type="date" class="form-control bg-transparent {{ !empty($field->prefix) ? !empty($field->prefix->type) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->type) ? 'border-right-0' : '' : '' }}" name="{{$field->name}}"
                       id="input{{$field->name}}" {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}">
                @if(!empty($field->prefix) || !empty($field->suffix))
                    @if(!empty($field->suffix))
                        @if(!empty($field->suffix->type))
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent border-left-0 text-primary">
                                    @if($field->suffix->type=='icon')
                                        <i class="text-primary {{ $field->suffix->value }}"></i>
                                    @else
                                        {{ $field->suffix->value }}
                                    @endif
                                </span>
                            </div>
                        @endif
                    @endif
                    </div>
                @endif
            @break
            @default
            <div class="checkbox">
                <label>
                    <input name="{!!$field['name']!!}" type="checkbox"
                            {{$field->required?'required':''}}>{!!sprintf(trans('iforms::form.form.terms'),url($field->description))!!}
                </label>
            </div>
        @endswitch
        </div>
    @endforeach
</div>



