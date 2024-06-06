<?php
$fields = $form->fields;
?>
{{ csrf_field() }}
@foreach($fields as $index => $field)

  <div class="form-group row">
    @switch($field->present()->type['value'])
      @case('text')
      <label for="input{{$field->name}}" class="col-sm-12 col-form-label">{{$field->label}}</label>
      <div class="col-sm-12">
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
          <input type="text" class="form-control {{ !empty($field->prefix) ? !empty($field->prefix->type) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->type) ? 'border-right-0' : '' : '' }}" name="{{$field->name}}"
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
      </div>
      @break

      @case('textarea')
      <label for="input{{$field->name}}" class="col-sm-12 col-form-label">{{$field->label}}</label>
      <div class="col-sm-12">
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
          <textarea class="form-control {{ !empty($field->prefix) ? !empty($field->prefix->type) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->type) ? 'border-right-0' : '' : '' }}" id="input{{$field->name}}" name="{{$field->name}}" placeholder="{{ $field->placeholder ?? '' }}" rows="4"></textarea>
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
      </div>
      @break
      @case('number')
      <label for="input{{$field->name}}" class="col-sm-12 col-form-label">{{$field->label}}</label>
      <div class="col-sm-12">
        @if(!empty($field->prefix) || !empty($field->suffix))
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
          <input type="number" class="form-control {{ !empty($field->prefix) ? !empty($field->prefix->type) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->type) ? 'border-right-0' : '' : '' }}" name="{{$field->name}}"
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
      </div>
      @break
      @case('email')
      <label for="input{{$field->name}}" class="col-sm-12 col-form-label">{{$field->label}}</label>
      <div class="col-sm-12">
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
          <input type="email" class="form-control {{ !empty($field->prefix) ? !empty($field->prefix->type) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->type) ? 'border-right-0' : '' : '' }}" name="{{$field->name}}"
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
      </div>
      @break
      @case('select')
        @case('selectmultiple')
        <label for="input{{$field->name}}" class="col-sm-12 col-form-label">{{$field->label}}</label>
        <div class="col-sm-12">
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
            <select {{ $field->present()->type['value']=='selectmultiple'?'multiple':'' }} class="form-control {{ !empty($field->prefix) ? !empty($field->prefix->type) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->type) ? 'border-right-0' : '' : '' }}" name="{{$field->name}}"
                   id="input{{$field->name}}" {{$field->required?'required':''}}   data-placeholder="{{ $field->placeholder ?? '' }}"
            >
              @foreach($options as $option)
                  <option value="{{ $option->name }}">{{ $option->name }}</option>
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
        </div>
      @break
      @case('radio')
      <label for="input{{$field->name}}" class="col-sm-12 col-form-label">{{$field->label}}</label>
      <div class="col-sm-12">
        @php
          $options = json_decode($field->selectable)
        @endphp
        @foreach($options as $option)
          <label>
            <input type="radio" name="{{$field->name}}" value="{{ $option->name }}"/>&nbsp; {{ $option->name  }} &nbsp;&nbsp;
          </label>
          @endforeach
      </div>
      @break
      @case('phone')
        <label for="input{{$field->name}}" class="col-sm-12 col-form-label">{{$field->label}}</label>
        <div class="col-sm-12">
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
            <input type="phone" class="form-control {{ !empty($field->prefix) ? !empty($field->prefix->type) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->type) ? 'border-right-0' : '' : '' }}" name="{{$field->name}}"
                 id="input{{$field->name}}" {{$field->required?'required':''}}  placeholder="{{ $field->placeholder ?? '' }}">
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
        </div>
      @break
      @case('date')
        <label for="input{{$field->name}}" class="col-sm-12 col-form-label">{{$field->label}}</label>
        <div class="col-sm-12">
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
            <input type="date" class="form-control {{ !empty($field->prefix) ? !empty($field->prefix->type) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->type) ? 'border-right-0' : '' : '' }}" name="{{$field->name}}"
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
        </div>
      @break

      @default
        <label class="col-sm-12 col-form-label">{{$field->label}}</label>
        <div class="col-sm-12">
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




