@php
    $id=str_slug($form->title).$options['rand'];;
@endphp

<div class="content-form{{$options['rand']}}">
    <div class="formerror"></div>
    <form id="{{$id}}" class="form-horizontal" action="{{route('api.iforms.leads.create')}}">
        <input type="hidden" name="form_id" value="{{$form->id}}" required="">

        @include('iforms::frontend.form.bt-nolabel.fields')

        @if(Setting::get('iforms::captcha')=="1")
            <div class="col-sm-12">
                {!!app('captcha')->display($attributes = ['data-sitekey'=>Setting::get('iforms::api')])!!}
                </br>
            </div>
        @endif
        <div class="w-100 text-right">
            <button type="submit" class="btn btn-primary">{{trans('iforms::forms.form.submit')}}</button>
        </div>
    </form>

</div>

@include('iforms::frontend.form.mainlayout')
