<?php
$fields = $form->fields;
?>
{{ csrf_field() }}
<div class="row">
  @foreach($fields as $index => $field)
    <div class="col-12 col-sm-{{ $field->width ?? '12' }}">
      <div class="form-group row">
        @switch($field->present()->type['value'])
          @case('text')
          <label class="col-3 col-form-label" for="input{{$field->name}}">{{$field->label}}</label>
          <div class="col-9">
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
                         {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}"/>
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
          <label class="col-3 col-form-label" for="input{{$field->name}}">{{$field->label}}</label>
          <div class="col-9">
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
                    placeholder="{{ $field->placeholder ?? '' }}"
                    name="{{$field->name}}" id="input{{$field->name}}" rows="4"></textarea>
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
          <label class="col-3 col-form-label" for="input{{$field->name}}">{{$field->label}}</label>
          <div class="col-9">
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
          <label class="col-3 col-form-label" for="input{{$field->name}}">{{$field->label}}</label>
          <div class="col-9">
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
                         {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}"/>
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
          <label class="col-3 col-form-label" for="input{{$field->name}}">{{$field->label}}</label>
          <div class="col-9">
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
          <label class="col-3 col-form-label" for="input{{$field->name}}">{{$field->label}}</label>
          <div class="col-9">
            @php
              $options = $field->options->fieldOptions ?? json_decode($field->selectable)
            @endphp
            @foreach($options as $k=>$option)
              <input class="form-check-input" id="input{{$field->name}}{{ $k }}" type="radio" name="{{$field->name}}"
                     value="{{ $option->name ?? $option }}"/>
              <label for="input{{$field->name}}{{ $k }}" class="form-check-label">{{ $option->name ?? $option }}</label>
            @endforeach
          </div>
          @break
          @case('phone')
          <label class="col-3 col-form-label" for="input{{$field->name}}">{{$field->label}}</label>
          <div class="col-9">
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
                  <input
                    class="form-control {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                    type="phone" name="{{$field->name}}"
                    id="input{{$field->name}}"
                    {{$field->required?'required':''}}   placeholder="{{ $field->placeholder ?? '' }}"/>
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
          <label class="col-3 col-form-label" for="{{$field->name}}">{{$field->label}}</label>
          <div class="col-9">
            @if(!empty($field->prefix) || !empty($field->suffix))
              @if(!empty($field->prefix->value) || !empty($field->suffix->value))
                <div class="input-group flex-nowrap">
                  @if(!empty($field->prefix))
                    @if(!empty($field->prefix->value))
                      <div class="input-group-prepend">
                                        <span class="input-group-text border-right-0 text-primary">
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
                         {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}"/>
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
          <label class="col-3 col-form-label" for="{{$field->name}}">{{$field->label}}</label>
          <div class="col-9">
            @if(!empty($field->prefix) || !empty($field->suffix))
              @if(!empty($field->prefix->value) || !empty($field->suffix->value))
                <div class="input-group flex-nowrap">
                  @if(!empty($field->prefix))
                    @if(!empty($field->prefix->value))
                      <div class="input-group-prepend">
                                            <span class="input-group-text border-right-0 text-primary">
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
                         name="{{$field->name}}" id="input{{$field->name}}"
                         {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}"/>
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
          <label class="col-3 col-form-label">{{$field->label}}</label>
          <div class="col-9">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="input{{$field->name}}">
              <label class="form-check-label" for="input{{$field->name}}">
                {{ $field->placeholder }}
              </label>
            </div>
          </div>
        @endswitch
      </div>
    </div>
  @endforeach
</div>
