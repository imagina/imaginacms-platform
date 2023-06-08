<?php
$fields = $form->fields;
?>
{{ csrf_field() }}
<div class="form-group row">
  @foreach($fields as $index => $field)
    <div class="col-12 col-sm-{{ $field->width ?? '12' }} col-style {{$field->name}}">
      @switch($field->present()->type['value'])
        @case('text')
        <label for="input{{$field->name}}" class="py-1 px-0 col-form-label">{{$field->label}}</label>
        <div class="input-frame">
          <div class="input-group flex-nowrap">
            @include('iforms::frontend.partials.xfix',["xfix" => $field->prefix,"type"=>"pre"])
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
            @include('iforms::frontend.partials.xfix',["xfix" => $field->suffix,"type"=>"suf"])
          </div>
          <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
        </div>
        @break
        @case('textarea')
        <label for="input{{$field->name}}" class="py-1 px-0 col-form-label">{{$field->label}}</label>
        <div class="input-frame">
          <div class="input-group flex-nowrap">
            @include('iforms::frontend.partials.xfix',["xfix" => $field->prefix,"type"=>"pre"])
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
            @include('iforms::frontend.partials.xfix',["xfix" => $field->suffix,"type"=>"suf"])
          </div>
          <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
        </div>
        @break
        @case('number')
        <label for="input{{$field->name}}" class="py-1 px-0 col-form-label">{{$field->label}}</label>
        <div class="input-frame">
          <div class="input-group flex-nowrap">
            @include('iforms::frontend.partials.xfix',["xfix" => $field->prefix,"type"=>"pre"])
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
            @include('iforms::frontend.partials.xfix',["xfix" => $field->suffix,"type"=>"suf"])
          </div>
          <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
        </div>
        @break
        @case('email')
        <label for="input{{$field->name}}" class="py-1 px-0 col-form-label">{{$field->label}}</label>
        <div class="input-frame">
          <div class="input-group flex-nowrap">
            @include('iforms::frontend.partials.xfix',["xfix" => $field->prefix,"type"=>"pre"])
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
            @include('iforms::frontend.partials.xfix',["xfix" => $field->suffix,"type"=>"suf"])
          </div>
          <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
        </div>
        @break
        @case('select')
        @case('selectmultiple')
        <label for="input{{$field->name}}" class="py-1 px-0 col-form-label">{{$field->label}}</label>
        <div class="input-frame">
          <div class="input-group flex-nowrap">
            @include('iforms::frontend.partials.xfix',["xfix" => $field->prefix,"type"=>"pre"])
            @php
              $options = $field->options->fieldOptions ?? $field->options["fieldOptions"] ??  json_decode($field->selectable);
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
            @include('iforms::frontend.partials.xfix',["xfix" => $field->suffix,"type"=>"suf"])
          </div>
          <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
        </div>
        @break
        @case('radio')
        <label for="input{{$field->name}}" class="py-1 px-0 col-form-label">{{$field->label}}</label>
        <div class="input-frame">
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
        <label for="input{{$field->name}}" class="py-1 px-0 col-form-label">{{$field->label}}</label>
        <div class="input-frame">
          <div class="input-group flex-nowrap">
            @include('iforms::frontend.partials.xfix',["xfix" => $field->prefix,"type"=>"pre"])
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
            @include('iforms::frontend.partials.xfix',["xfix" => $field->suffix,"type"=>"suf"])
          </div>
          <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
        </div>
        @break
        @case('date')
        <label for="input{{$field->name}}" class="py-1 px-0 col-form-label">{{$field->label}}</label>
        <div class="input-frame">
          <div class="input-group flex-nowrap">
            @include('iforms::frontend.partials.xfix',["xfix" => $field->prefix,"type"=>"pre"])
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
            @include('iforms::frontend.partials.xfix',["xfix" => $field->suffix,"type"=>"suf"])
          </div>
          <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
        </div>
        @break
        @case('file')
        <label for="input{{$field->name}}" class="py-1 px-0 col-form-label">{{$field->label}}
          {{!empty($field->rule_accept) ? "(".$field->rule_accept.")" : "" }}
        </label>
        <div class="input-frame">
          <div class="input-group flex-nowrap">
            @include('iforms::frontend.partials.xfix',["xfix" => $field->prefix,"type"=>"pre"])
            <input type="file"
                   {{ !empty($field->rule_accept)? "accept=".$field->rule_accept : ""}}
                   class="form-control-file border-0 {{ !empty($field->prefix) ? !empty($field->prefix->value) ? 'border-left-0' : '' : '' }} {{ !empty($field->suffix) ? !empty($field->suffix->value) ? 'border-right-0' : '' : '' }}"
                   name="{{$field->name}}"
                   id="input{{$field->name}}"
                   {{$field->required?'required':''}} placeholder="{{ $field->placeholder ?? '' }}">
            @include('iforms::frontend.partials.xfix',["xfix" => $field->suffix,"type"=>"suf"])
          </div>
          <small id="{{$field->name}}Help" class="form-text text-muted">{{$field->description}}</small>
        </div>
        @break
        @default
        <label class="py-1 px-0 col-form-label">{{$field->label}}</label>
        <div class="input-frame">
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
