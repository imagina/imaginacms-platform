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
            <label for="merchantId">* {{trans('icommercecredibanco::icommercecredibancos.table.merchantId')}}</label>
            <input placeholder="{{trans('icommercecredibanco::icommercecredibancos.table.merchantId')}}" required="required" name="merchantId" type="text" id="merchantId" class="form-control" value="{{$method->options->merchantId}}">
        </div>

        <div class="form-group ">
            <label for="nroTerminal">* {{trans('icommercecredibanco::icommercecredibancos.table.nroTerminal')}}</label>
            <input placeholder="{{trans('icommercecredibanco::icommercecredibancos.table.nroTerminal')}}" required="required" name="nroTerminal" type="text" id="nroTerminal" class="form-control" value="{{$method->options->nroTerminal}}">
        </div>

        <div class="form-group ">
            <label for="vec">* {{trans('icommercecredibanco::icommercecredibancos.table.vec')}}</label>
            <input placeholder="{{trans('icommercecredibanco::icommercecredibancos.table.vec')}}" required="required" name="vec" type="text" id="vec" class="form-control" value="{{$method->options->vec}}">
        </div>

        <div class="form-group">
            <label for="mode">* {{trans('icommercecredibanco::icommercecredibancos.table.mode')}}</label>
            <select class="form-control" id="mode" name="mode" required>
                    <option value="sandbox" @if(!empty($method->options->mode) && $method->options->mode=='sandbox') selected @endif>SANDBOX</option>
                    <option value="live" @if(!empty($method->options->mode) && $method->options->mode=='live') selected @endif>LIVE</option>
            </select>
        </div>

        <div class="form-group ">
            <label for="privateCrypto">* {{trans('icommercecredibanco::icommercecredibancos.table.privateCrypto')}}</label>
            <input placeholder="{{trans('icommercecredibanco::icommercecredibancos.table.privateCrypto')}}" required="required" name="privateCrypto" type="text" id="privateCrypto" class="form-control" value="{{$method->options->privateCrypto}}">
        </div>

        <div class="form-group ">
            <label for="privateSign">* {{trans('icommercecredibanco::icommercecredibancos.table.privateSign')}}</label>
            <input placeholder="{{trans('icommercecredibanco::icommercecredibancos.table.privateSign')}}" required="required" name="privateSign" type="text" id="privateSign" class="form-control" value="{{$method->options->privateSign}}">
        </div>

        <div class="form-group ">
            <label for="publicCrypto">* {{trans('icommercecredibanco::icommercecredibancos.table.publicCrypto')}}</label>
            <input placeholder="{{trans('icommercecredibanco::icommercecredibancos.table.publicCrypto')}}" required="required" name="publicCrypto" type="text" id="publicCrypto" class="form-control" value="{{$method->options->publicCrypto}}">
        </div>

        <div class="form-group ">
            <label for="publicSign">* {{trans('icommercecredibanco::icommercecredibancos.table.publicSign')}}</label>
            <input placeholder="{{trans('icommercecredibanco::icommercecredibancos.table.publicSign')}}" required="required" name="publicSign" type="text" id="publicSign" class="form-control" value="{{$method->options->publicSign}}">
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
    
    @include('icommercecredibanco::admin.icommercecredibancos.partials.featured-img',['crop' => 0,'name' => 'mainimage','action' => 'create'])
    
</div>
    
    
 <div class="clearfix"></div>  
 
 <div class="col-xs-12">
    <div class="alert alert-info">
        <strong>Info!</strong> {{trans('icommercecredibanco::icommercecredibancos.messages.info')}}
      </div>	
</div>

    <div class="box-footer">
    <button type="submit" class="btn btn-primary btn-flat">{{ trans('icommerce::paymentmethods.button.save configuration') }} {{$method->title}}</button>
    </div>



{!! Form::close() !!}