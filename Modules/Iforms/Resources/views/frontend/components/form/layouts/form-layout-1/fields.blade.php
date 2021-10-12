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
                       class="form-control {{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['class'] ?? '') :'' }} {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
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
                  class="form-control {{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['class'] ?? '') :'' }} {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                  id="input{{$field->name}}"
                  name="{{$field->name}}"
                  value="{{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['value'] ?? '') : '' }}"
                  @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['disabled'])) disabled
                  @endif
                  @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['readonly'])) readonly="true"
                  @endif
                  placeholder="{{ $field->placeholder ?? '' }}" rows="4"></textarea>
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
                       class="form-control {{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['class'] ?? '') :'' }} {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
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
                       class="form-control {{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['class'] ?? '') :'' }} {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
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
                <select {{ $field->present()->type['value']=='selectmultiple'?'multiple':'' }}
                        class="form-control {{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['class'] ?? '') :'' }} {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                        name="{{$field->name}}"
                        value="{{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['value'] ?? '') : '' }}"
                        @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['disabled'])) disabled
                        @endif
                        @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['readonly'])) readonly
                        @endif
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
          <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
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
                       class="form-control {{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['class'] ?? '') :'' }} {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                       name="{{$field->name}}"
                       value="{{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['value'] ?? '') : '' }}"
                       @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['disabled'])) disabled
                       @endif
                       @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['readonly'])) readonly
                       @endif
                       id="input{{$field->name}}"
                       {{$field->required?'required':''}}  placeholder="{{ $field->placeholder ?? '' }}">
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
                       class="form-control {{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['class'] ?? '') :'' }} {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
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
        </div>
        @break

        @case('file')
        <label for="input{{$field->name}}" class="col-12 py-1 px-1 col-form-label">{{$field->label}}
          {{!empty($field->rule_accept) ? "(".$field->rule_accept.")" : "" }}
        </label>
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
                       {{ !empty($field->rule_accept)? "accept=".$field->rule_accept : ""}}
                       class="form-control-file border-0 {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                       name="{{$field->name}}"
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
        </div>
        @break
        @default
        <label class="col-12 py-1 px-1 col-form-label">{{$field->label}}</label>
        <div class="col-12 py-1 px-1">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="input{{$field->name}}"
                   value="{{ isset($fieldsParams[$field->name]) ? ($fieldsParams[$field->name]['value'] ?? '') : '' }}"
                   @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['readonly'])) readonly
                   @endif
                   @if(isset($fieldsParams[$field->name]) && isset($fieldsParams[$field->name]['disabled'])) disabled @endif
            />
            <label class="form-check-label" for="input{{$field->name}}">
              {{ $field->placeholder }}
            </label>
          </div>
        </div>
      @endswitch
    </div>
  @endforeach
</div>
