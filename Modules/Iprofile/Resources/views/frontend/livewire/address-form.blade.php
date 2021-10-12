<div class="address-form my-2">

            @if($openInModal)
                <button
                        type="button"
                        class="btn btn-sm btn-outline-primary"
                        data-toggle="modal"
                        data-target="#addressModal{{$type}}"
                ><i class="fa fa-plus-circle"></i> {{trans('iprofile::addresses.title.create address')}}</button>

                <div wire:ignore.self class="modal fade" id="addressModal{{$type}}" tabindex="-1" role="dialog" aria-labelledby="addressModal{{$type}}"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"
                                    id="exampleModalLabel">{{trans('iprofile::addresses.title.create address')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @endif


                                <form class="needs-validation" novalidate wire:submit.prevent="save">

                                    @if(!empty($type))
                                        <input wire:model.defer="address.type" type="hidden" value="{{$type}}">
                                    @endif

                                    <div class="form-group row pt-2">
                                        <div class="col pr-1">
                                            <label for="payment_firstname">{{ trans('iprofile::addresses.form.firstName') }} </label>
                                            <input class="form-control" type="text"
                                                   id="paymentFirstname"
                                                   wire:model.defer="address.first_name">
                                            {!! $errors->first("address.first_name", '<span class="help-block">:message</span>') !!}

                                        </div>
                                        <div class="col pl-1">
                                            <label for="payment_lastname">{{ trans('iprofile::addresses.form.lastName') }}</label>
                                            <input class="form-control" type="text"
                                                   id="paymentLastname"
                                                   wire:model.defer="address.last_name">
                                            {!! $errors->first("address.last_name", '<span class="help-block">:message</span>') !!}
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="payment_address_1">{{ trans('iprofile::addresses.form.address1') }}</label>
                                        <input class="form-control" type="text"
                                               id="paymentAddress1"
                                               wire:model.defer="address.address_1">
                                        {!! $errors->first("address.address_1", '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_telephone">{{ trans('iprofile::addresses.form.telephone') }}</label>
                                        <input type="number"
                                               class="form-control"
                                               id="paymentTelephone"
                                               wire:model.defer="address.telephone">
                                        {!! $errors->first("address.telephone", '<span class="help-block">:message</span>') !!}
                                    </div>

                                    <div class="form-group">
                                        <label for="payment_country">{{ trans('iprofile::addresses.form.country') }}</label>
                                        <select id="paymentCountry"
                                                class="form-control"
                                                wire:model="address.country">
                                            <option value="">{{ trans('iprofile::addresses.form.select_country') }}</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->iso_2}}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first("address.country", '<span class="help-block">:message</span>') !!}
                                    </div>
    
    
                                        <div class="form-group">
        
                                            <label for="paymentState">{{ trans('iprofile::addresses.form.state') }}</label>
                                            <select id="paymentState"
                                                    class="form-control"
                                                    wire:model="address.state">
                                              
                                                    <option value="">{{ trans('iprofile::addresses.form.select_province') }}</option>
                                           
                                                @foreach($provinces as $province)
                                                    <option value="{{$province->iso_2}}">{{ $province->name }}</option>
                                                @endforeach
                                            </select>
                                       
                                            {!! $errors->first("address.state", '<span class="help-block">:message</span>') !!}
                                        </div>
    
                                        <div class="form-group">
        
                                            <label for="paymentCity">{{ trans('iprofile::addresses.form.city') }}</label>
                                            <select id="paymentCity"
                                                    class="form-control"
                                                    wire:model.defer="address.city_id">
                                                <option value="">{{ trans('iprofile::addresses.form.select_city') }}</option>
                                              
                                             
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            {!! $errors->first("address.state", '<span class="help-block">:message</span>') !!}
                                        </div>
                                

                                    @foreach($addressesExtraFields as $extraField)
                                        {{-- if is active--}}
                                        @if($extraField->active)

                                            {{-- form group--}}
                                            <div class="form-group">
                                                @php(!isset($extraField->type) ? $extraField->type = "text" : false)
                                                {{-- label --}}
                                                <label for="{{$extraField->field}}">{{trans("iprofile::frontend.form.$extraField->field")}}</label>

                                                {{-- Generic input --}}
                                                @if( !in_array($extraField->type, ["select","textarea"]) )

                                                    {{-- Document input --}}
                                                    @if($extraField->type == "documentType")

                                                        {{-- foreach options --}}
                                                        @if(isset($extraField->availableOptions) && is_array($extraField->availableOptions) && count($extraField->availableOptions))
                                                            @php($optionValues = [])
                                                            @foreach($extraField->availableOptions as $availableOption)
                                                                {{-- finding if the availableOption exist in the options and get the full option object --}}
                                                                @foreach ($extraField->options as $option)
                                                                    @if($option->value == $availableOption)
                                                                        @php($optionValues[] = $option)
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        @else
                                                            @php($optionValues = $extraField->options)
                                                        @endif

                                                        {{-- Select Document Type --}}
                                                        <select id="{{$extraField->field}}"
                                                                wire:model.defer="address.options.{{$extraField->field}}"
                                                                class="form-control">
                                                            <option value="">{{ trans('iprofile::addresses.form.select_option') }}</option>
                                                            {{-- select options --}}
                                                            @foreach($optionValues as $option)
                                                                <option value="{{$option->value}}">{{$option->label}}</option>

                                                            @endforeach {{--- end foreach options --}}
                                                        </select>
                                                        {!! $errors->first("address.options.$extraField->field", '<span class="help-block">:message</span>') !!}

                                            </div>
                                            {{-- DocumentNumber input --}}
                                            <div class="form-group">

                                                {{-- label --}}
                                                <label for="documentNumber">{{trans("iprofile::frontend.form.documentNumber")}}</label>
                                                <input id="documentNumber"
                                                       type="number"
                                                       min="0"
                                                       max="9999999999"
                                                       class="form-control"
                                                       wire:model.defer="address.options.documentNumber"/>
                                                {!! $errors->first("address.options.documentNumber", '<span class="help-block">:message</span>') !!}
                                                @else
                                                    <input id="{{$extraField->field}}"
                                                           type="{{$extraField->type}}"
                                                           class="form-control"
                                                           wire:model.defer="address.options.{{$extraField->field}}"/>
                                                    {!! $errors->first("address.options.$extraField->field", '<span class="help-block">:message</span>') !!}
                                                @endif
                                                @else
                                                    {{-- if is select --}}
                                                    @if($extraField->type == "select")
                                                        {{-- foreach options --}}
                                                        @if(isset($extraField->availableOptions) && is_array($extraField->availableOptions) && count($extraField->availableOptions))
                                                            @php($optionValues = [])
                                                            @foreach($extraField->availableOptions as $availableOption)
                                                                {{-- finding if the availableOption exist in the options and get the full option object --}}
                                                                @foreach ($extraField->options as $option)
                                                                    @if($option->value == $availableOption)
                                                                        @php($optionValues[] = $option)
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        @else
                                                            @php($optionValues = $extraField->options)
                                                        @endif

                                                        {{-- Select --}}
                                                        <select id="{{$extraField->field}}"
                                                                wire:model.defer="address.options.{{$extraField->field}}"
                                                                class="form-control">
                                                            <option value="">{{ trans('iprofile::addresses.form.select_option') }}</option>
                                                            {{-- validate availableOptions and options --}}
                                                            @foreach($optionValues as $option)
                                                                <option value="{{$option->value}}">{{$option->label}}</option>

                                                            @endforeach {{--- end foreach options --}}
                                                        </select>
                                                        {!! $errors->first("address.options.$extraField->field", '<span class="help-block">:message</span>') !!}
                                                    @else
                                                        {{-- if is textarea --}}
                                                        @if($extraField->type == "textarea")
                                                            {{-- Textarea --}}
                                                            <textarea id="{{$extraField->field}}"
                                                                      wire:model.defer="address.options.{{$extraField->field}}"
                                                                      class="form-control" cols="30"
                                                                      rows="3"></textarea>
                                                            {!! $errors->first("address.options.$extraField->field", '<span class="help-block">:message</span>') !!}
                                                        @endif {{--- end if is textarea --}}
                                                    @endif {{-- end if is select --}}
                                                @endif {{-- end if is generic input --}}
                                            </div>
                                        @endif {{-- end if is active --}}
                                    @endforeach

                                    <div class="form-check">

                                        <label class="form-check-label">
                                            <input type="checkbox"
                                                   wire:model.defer="address.default">
                                            @switch($type)
                                                @case('billing')
                                                {{ trans('iprofile::frontend.form.defaultBilling') }}
                                                @break;
                                                @case('shipping')
                                                {{ trans('iprofile::frontend.form.defaultShipping') }}
                                                @break;

                                            @endswitch
                                        </label>
                                    </div>

                                    <div class="form-group text-center">

                                        <button type="submit" class="btn btn-primary"
                                                name="button"> {{ trans('iprofile::addresses.button.add_address') }}
                                        </button>
                                    </div>


                                </form>

                                @if($openInModal)


                            </div>
                        </div>
                    </div>
                </div>

            @endif

</div>

@section('scripts')
    @parent
    <script type="text/javascript">
      window.livewire.on('addressAdded', () => {
        $('#addressModal{{$type}}').modal('hide')
      });
    </script>
@stop

