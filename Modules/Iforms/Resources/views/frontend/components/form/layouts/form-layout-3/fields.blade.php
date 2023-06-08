<?php
$fields = $form->fields;
?>
{{ csrf_field() }}
<div class="form-group row mb-0">
  @foreach($fields as $field)
    <div class="col-12 col-sm-{{ $field->width ?? '12' }} col-style">
      @switch($field->present()->type['value'])
        @case('text')
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
                     class="form-control bg-transparent {{ isset($fieldsParams[$field->name]) ? $fieldsParams[$field->name]['class'] ?? '' :'' }} {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                     name="{{$field->name}}"
                     value="{{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['value']) ?? '' : '' }}"
                     @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['disabled'])) disabled
                     @endif
                     @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['readonly'])) readonly
                     @endif
                     id="input{{$field->name}}"
                     {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}">
                <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
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
        @break

        @case('textarea')
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
                class="form-control bg-transparent {{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['class'] ?? '') :'' }} {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                value="{{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['value'] ?? '') : '' }}"
                @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['disabled'])) disabled
                @endif
                @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['readonly'])) readonly
                @endif
                name="{{$field->name}}"
                placeholder="{{ $field->placeholder ?? '' }}"
                rows="4" id="input{{$field->name}}"></textarea>
                <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
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
        @break
        @case('number')
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
              <input type="number"
                     class="form-control bg-transparent {{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['class'] ?? '') :'' }} {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                     name="{{$field->name}}"
                     value="{{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['value'] ?? '') : '' }}"
                     @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['disabled'])) disabled
                     @endif
                     @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['readonly'])) readonly
                     @endif
                     id="input{{$field->name}}"
                     {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}">
                <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
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
        @break
        @case('email')
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
                     class="form-control bg-transparent {{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['class'] ?? '') :'' }} {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                     name="{{$field->name}}"
                     value="{{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['value'] ?? '') : '' }}"
                     @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['disabled'])) disabled
                     @endif
                     id="input{{$field->name}}"
                     {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}">
                <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
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
        @break
        @case('select')
        @case('selectmultiple')
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
                {{ $field->present()->type['value']=='selectmultiple'?'multiple':'' }} class="form-control bg-transparent {{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['class'] ?? '') :'' }} {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                value="{{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['value'] ?? '') : '' }}"
                @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['disabled'])) disabled
                @endif
                @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['readonly'])) readonly
                @endif
                name="{{$field->name}}"
                id="input{{$field->name}}"
                {{$field->required?'required':''}}   data-placeholder="{{ $field->placeholder ?? '' }}"
              >
                @foreach($options as $option)
                  <option value="{{ $option->name ?? $option }}">{{ $option->name ?? $option }}</option>
                @endforeach
              </select>
                <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
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
        @break
        @case('radio')
        @php
          $options = $field->options->fieldOptions ?? json_decode($field->selectable)
        @endphp
        @foreach($options as $option)
          <label>
            <input type="radio" name="{{$field->name}}"
                   value="{{ $option->name ?? $option }}"/>&nbsp; {{ $option->name ?? $option }} &nbsp;&nbsp;
          </label>
        @endforeach
      <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
        @break
        @case('phone')
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
                     class="form-control bg-transparent {{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['class'] ?? '') :'' }} {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                     value="{{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['value'] ?? '') : '' }}"
                     @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['disabled'])) disabled
                     @endif
                     @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['readonly'])) readonly
                     @endif
                     name="{{$field->name}}"
                     id="input{{$field->name}}"
                     {{$field->required?'required':''}}   placeholder="{{ $field->placeholder ?? '' }}">
                <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
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
        @break
        @case('date')
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
                     class="form-control bg-transparent {{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['class'] ?? '') :'' }} {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                     name="{{$field->name}}"
                     value="{{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['value'] ?? '') : '' }}"
                     @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['disabled'])) disabled
                     @endif
                     @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['readonly'])) readonly
                     @endif
                     id="input{{$field->name}}"
                     {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}">
                <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
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
        @break
        @case('file')
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
                     {{ !empty($field->rule_accept)? "accept=".$field->rule_accept : ""}}
                     class="form-control bg-transparent {{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['class'] ?? '') :'' }} {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                     name="{{$field->name}}"
                     value="{{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['value'] ?? '') : '' }}"
                     @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['disabled'])) disabled
                     @endif
                     @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['readonly'])) readonly
                     @endif
                     id="input{{$field->name}}"
                     {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}">
                <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
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
