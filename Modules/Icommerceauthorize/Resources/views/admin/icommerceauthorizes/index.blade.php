@php
    $options = array('required' =>'required');
    $formID = uniqid("form_id");
@endphp

{!! Form::open(['route' => ['admin.icommerce.paymentmethod.update',$method->id], 'method' => 'put','name' => $formID]) !!}

<div class="col-xs-12 col-sm-9">

    <div class="row">

        <div class="nav-tabs-custom">
            @include('partials.form-tab-headers')
            <div class="tab-content">
                <?php $i = 0; ?>
                @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                    <?php $i++; ?>
                    <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="{{$method->name}}_tab_{{ $i }}">
                        
                        {!! Form::i18nInput('title', trans('icommerce::paymentmethods.table.title'), $errors, $locale, $method) !!}
                        {!! Form::i18nInput('description', trans('icommerce::paymentmethods.table.description'), $errors, $locale, $method) !!}
                    
                    </div>
                @endforeach
            </div>
        </div>
        
    </div>

    <div class="row">
    <div class="col-xs-12">
        
        <div class="form-group ">
            <label for="api_login">{{trans('icommerceauthorize::icommerceauthorizes.table.api_login')}}</label>
            <input placeholder="{{trans('icommerceauthorize::icommerceauthorizes.table.api_login')}}" required="required" name="api_login" type="text" id="api_login" class="form-control" value="{{$method->options->apilogin}}">
        </div>

        <div class="form-group ">
            <label for="transaction_key">{{trans('icommerceauthorize::icommerceauthorizes.table.transaction_key')}}</label>
            <input placeholder="{{trans('icommerceauthorize::icommerceauthorizes.table.transaction_key')}}" required="required" name="transaction_key" type="text" id="transaction_key" class="form-control" value="{{$method->options->transactionkey}}">
        </div>

        <div class="form-group ">
            <label for="client_key">{{trans('icommerceauthorize::icommerceauthorizes.table.client_key')}}</label>
            <input placeholder="{{trans('icommerceauthorize::icommerceauthorizes.table.client_key')}}" required="required" name="client_key" type="text" id="client_key" class="form-control" value="{{$method->options->clientkey}}">
        </div>

        <div class="form-group">
            <label for="mode">{{trans('icommerceauthorize::icommerceauthorizes.table.mode')}}</label>
            <select class="form-control" id="mode" name="mode" required>
                    <option value="sandbox" @if(!empty($method->options->mode) && $method->options->mode=='sandbox') selected @endif>SANDBOX</option>
                    <option value="live" @if(!empty($method->options->mode) && $method->options->mode=='live') selected @endif>LIVE</option>
            </select>
        </div>

        <div class="form-group">
            <div>
                <label class="checkbox-inline">
                    <input name="status" type="checkbox" @if($method->status==1) checked @endif>{{trans('icommerce::paymentmethods.table.activate')}}
                </label>
            </div>   
        </div>

    </div>
    </div>

</div>

<div class="col-sm-3">
    
    @include('icommerceauthorize::admin.icommerceauthorizes.partials.featured-img',['crop' => 0,'name' => 'mainimage','action' => 'create'])
    
</div>
    
    
 <div class="clearfix"></div>   

    <div class="box-footer">
    <button type="submit" class="btn btn-primary btn-flat">{{ trans('icommerce::paymentmethods.button.save configuration') }} {{$method->title}}</button>
    </div>



{!! Form::close() !!}