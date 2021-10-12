<?php
$fields = $form->fields;
?>
{{ csrf_field() }}
<div class="form-group row">
  @foreach($fields as $index => $field)
    <div class="col-12 col-sm-{{ $field->width ?? '12' }} py-1 px-1">
      @switch($field->present()->type['value'])
        @case('text')
        <label for="input{{$field->name}}" class="col-12 py-1 px-1 col-form-label">{{$field->label}}</label>
        <div class="col-12 py-1 px-1">
          @if(!empty($field->prefix) || !empty($field->suffix))
            @if(!empty($field->prefix->value) || !empty($field->suffix->value))
              <div class="input-group flex-nowrap">
                @if(!empty($field->prefix))
                  @if(!empty($field->prefix->value))
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
                @endif
                <input type="text"
                       class="form-control {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                       name="{{$field->name}}"
                       id="input{{$field->name}}"
                       {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}">
                @if(!empty($field->prefix) || !empty($field->suffix))
                  @if(!empty($field->prefix->value) || !empty($field->suffix->value))
                    @if(!empty($field->suffix))
                      @if(!empty($field->suffix->value))
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
          @endif
        </div>
        @break

        @case('textarea')
        <label for="input{{$field->name}}" class="col-12 py-1 px-1 col-form-label">{{$field->label}}</label>
        <div class="col-12 py-1 px-1">
          @if(!empty($field->prefix) || !empty($field->suffix))
            @if(!empty($field->prefix->value) || !empty($field->suffix->value))
              <div class="input-group flex-nowrap">
                @if(!empty($field->prefix))
                  @if(!empty($field->prefix->value))
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
                @endif
                <textarea
                  class="form-control {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                  id="input{{$field->name}}" name="{{$field->name}}" placeholder="{{ $field->placeholder ?? '' }}"
                  rows="4"></textarea>
                @if(!empty($field->prefix) || !empty($field->suffix))
                  @if(!empty($field->prefix->value) || !empty($field->suffix->value))
                    @if(!empty($field->suffix))
                      @if(!empty($field->suffix->value))
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
          @endif
        </div>
        @break
        @case('number')
        <label for="input{{$field->name}}" class="col-12 py-1 px-1 col-form-label">{{$field->label}}</label>
        <div class="col-12 py-1 px-1">
          @if(!empty($field->prefix) || !empty($field->suffix))
            @if(!empty($field->prefix->value) || !empty($field->suffix->value))
              <div class="input-group flex-nowrap">
                @if(!empty($field->prefix))
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
                <input type="number"
                       class="form-control {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                       name="{{$field->name}}"
                       id="input{{$field->name}}"
                       {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}">
                @if(!empty($field->prefix) || !empty($field->suffix))
                  @if(!empty($field->prefix->value) || !empty($field->suffix->value))
                    @if(!empty($field->suffix))
                      @if(!empty($field->suffix->value))
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
          @endif
        </div>
        @break
        @case('email')
        <label for="input{{$field->name}}" class="col-12 py-1 px-1 col-form-label">{{$field->label}}</label>
        <div class="col-12 py-1 px-1">
          @if(!empty($field->prefix) || !empty($field->suffix))
            @if(!empty($field->prefix->value) || !empty($field->suffix->value))
              <div class="input-group flex-nowrap">
                @if(!empty($field->prefix))
                  @if(!empty($field->prefix->value))
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
                @endif
                <input type="email"
                       class="form-control {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                       name="{{$field->name}}"
                       id="input{{$field->name}}"
                       {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}">
                @if(!empty($field->prefix) || !empty($field->suffix))
                  @if(!empty($field->prefix->value) || !empty($field->suffix->value))
                    @if(!empty($field->suffix))
                      @if(!empty($field->suffix->value))
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
          @endif
        </div>
        @break
        @case('select')
        @case('selectmultiple')
        <label for="input{{$field->name}}" class="col-12 py-1 px-1 col-form-label">{{$field->label}}</label>
        <div class="col-12 py-1 px-1">
          @if(!empty($field->prefix) || !empty($field->suffix))
            @if(!empty($field->prefix->value) || !empty($field->suffix->value))
              <div class="input-group flex-nowrap">
                @if(!empty($field->prefix))
                  @if(!empty($field->prefix->value))
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
                @endif
                @php
                  $options = $field->options->fieldOptions ?? json_decode($field->selectable)
                @endphp
                <select
                  {{ $field->present()->type['value']=='selectmultiple'?'multiple':'' }} class="form-control {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                  name="{{$field->name}}"
                  id="input{{$field->name}}"
                  {{$field->required?'required':''}}   data-placeholder="{{ $field->placeholder ?? '' }}"
                >
                  @foreach($options as $option)
                    <option value="{{ $option->name ?? $option }}">{{ $option->name ?? $option }}</option>
                  @endforeach
                </select>
                @if(!empty($field->prefix) || !empty($field->suffix))
                  @if(!empty($field->prefix->value) || !empty($field->suffix->value))
                    @if(!empty($field->suffix))
                      @if(!empty($field->suffix->value))
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
          @endif
        </div>
        @break
        @case('radio')
        <label for="input{{$field->name}}" class="col-12 py-1 px-1 col-form-label">{{$field->label}}</label>
        <div class="col-12 py-1 px-1">
          @php
            $options = $field->options->fieldOptions ?? json_decode($field->selectable)
          @endphp
          @foreach($options as $option)
            <label>
              <input type="radio" name="{{$field->name}}"
                     value="{{ $option->name ?? $option }}"/>&nbsp; {{ $option->name ?? $option }} &nbsp;&nbsp;
            </label>
          @endforeach
        </div>
        @break
        @case('phone')
        <label for="input{{$field->name}}" class="col-12 py-1 px-1 col-form-label">{{$field->label}}</label>
        <div class="col-12 py-1 px-1">
          @if(!empty($field->prefix) || !empty($field->suffix))
            @if(!empty($field->prefix->value) || !empty($field->suffix->value))
              <div class="input-group flex-nowrap">
                @if(!empty($field->prefix))
                  @if(!empty($field->prefix->value))
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
                @endif
                <input type="phone"
                       class="form-control {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                       name="{{$field->name}}"
                       id="input{{$field->name}}"
                       {{$field->required?'required':''}}  placeholder="{{ $field->placeholder ?? '' }}">
                @if(!empty($field->prefix) || !empty($field->suffix))
                  @if(!empty($field->prefix->value) || !empty($field->suffix->value))
                    @if(!empty($field->suffix))
                      @if(!empty($field->suffix->value))
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
          @endif
        </div>
        @break
        @case('date')
        <label for="input{{$field->name}}" class="col-12 py-1 px-1 col-form-label">{{$field->label}}</label>
        <div class="col-12 py-1 px-1">
          @if(!empty($field->prefix) || !empty($field->suffix))
            @if(!empty($field->prefix->value) || !empty($field->suffix->value))
              <div class="input-group flex-nowrap">
                @if(!empty($field->prefix))
                  @if(!empty($field->prefix->value))
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
                @endif
                <input type="date"
                       class="form-control {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                       name="{{$field->name}}"
                       id="input{{$field->name}}"
                       {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}">
                @if(!empty($field->prefix) || !empty($field->suffix))
                  @if(!empty($field->prefix->value) || !empty($field->suffix->value))
                    @if(!empty($field->suffix))
                      @if(!empty($field->suffix->value))
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
          @endif
        </div>
        @break
        @case('file')
        <label for="input{{$field->name}}" class="col-12 py-1 px-1 col-form-label">{{$field->label}}</label>
        <div class="col-12 py-1 px-1">
          @if(!empty($field->prefix) || !empty($field->suffix))
            @if(!empty($field->prefix->value) || !empty($field->suffix->value))
              <div class="input-group flex-nowrap">
                @if(!empty($field->prefix))
                  @if(!empty($field->prefix->value))
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
                @endif
                <input type="file"
                       class="form-control {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                       name="{{$field->name}}"
                       id="input{{$field->name}}"
                       {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}">
                @if(!empty($field->prefix) || !empty($field->suffix))
                  @if(!empty($field->prefix->value) || !empty($field->suffix->value))
                    @if(!empty($field->suffix))
                      @if(!empty($field->suffix->value))
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
          @endif
        </div>
        @break
        @default
        <label class="col-12 py-1 px-1 col-form-label">{{$field->label}}</label>
        <div class="col-12 py-1 px-1">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="input{{$field->name}}">
            <label class="form-check-label" for="input{{$field->name}}">
              {{ $field->placeholder }}
            </label>
          </div>
        </div>
      @endswitch
    </div>
  @endforeach
</div>
