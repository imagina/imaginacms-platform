@if(isset($address->id))
<div id="billingAddressResume" class="card p-2" style="font-size: 12px">
    <p class="card-text m-0"><b>{{trans("iprofile::addresses.form.name")}}
            :</b> {{$address->first_name}} {{ $address->last_name }}</p>
    <p class="card-text m-0"><b>{{trans("iprofile::addresses.form.phone")}}
            :</b> {{$address->telephone}}</p>
    <p class="card-text m-0"><b>{{trans("iprofile::addresses.form.address")}}
            :</b> {{$address->address_1}} {{ $address->address_2 ?  ", ".$address->address_2 : ""}}
    </p>
    <p class="card-text m-0"><b>{{trans("iprofile::addresses.form.city")}}
            :</b> {{$address->city}}</p>
    <p class="card-text m-0"><b>{{trans("iprofile::addresses.form.state")}}
            :</b> {{$address->state}}</p>
    <p class="card-text m-0"><b>{{trans("iprofile::addresses.form.country")}}
            :</b> {{$address->country}}</p>
    @if(isset($address->options) && !empty($address->options))
        <div>

            @foreach($addressesExtraFields as $extraField)
                @if($extraField->active)
                    @if($extraField->type == "documentType")
                        @if(isset($address->options) && isset($address->options->documentType))
                            <p class="card-text m-0"><b>{{trans("iprofile::addresses.form.identification")}}
                                    :</b> {{$address->options->documentType ?? '-'}}</p>
                        @endif
                        @if(isset($address->options) && isset($address->options->documentNumber))
                            <p class="card-text m-0"><b>{{trans("iprofile::addresses.form.documentNumber")}}
                                    :</b> {{$address->options->documentNumber ?? '-'}}</p>
                        @endif
                    @elseif(isset($address->options) && isset($address->options->{$extraField->field}))
                        <p class="card-text m-0"><b>{{trans("iprofile::addresses.form.$extraField->field")}}
                                :</b> {{$address->options->{$extraField->field} ?? '-'}}</p>
                    @endif

                @endif
            @endforeach
        </div>
    @endif

    @if($address->default)
    <p class="card-text m-0" v-if="billingAddress.default">
        {{trans("iprofile::addresses.form.default")}}
        @if($address->type == 'billing')
            <span>({{trans("iprofile::addresses.form.billing")}})</span>
        @endif
        @if($address->type == 'shipping')
            <span>({{trans("iprofile::addresses.form.shipping")}})</span>
        @endif
    </p>
        @endif
</div>
@else
    <div id="billingAddressResume" class="card p-2" style="font-size: 12px">
        No valid address
    </div>

    @endif