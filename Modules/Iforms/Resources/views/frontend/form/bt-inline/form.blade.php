@php
    $id=str_slug($form->title).rand(1,999);
@endphp

<div class="content-form{{$id}}">
    <div class="formerror"></div>
    <form id="{{$id}}" class="full-width" action="{{route('api.iforms.leads.create')}}">

        <input type="hidden" name="form_id" value="{{$form->id}}" required="">

        @include('iforms::frontend.form.bt-inline.fields')

        @if(Setting::get('iforms::captcha')=="1")
            <div class="col-sm-offset-2 col-sm-10">
                {!!app('captcha')->display($attributes = ['data-sitekey'=>Setting::get('iforms::api')])!!}
                </br>
                </br>
            </div>
        @endif
        <div class="w-100 text-right">
            <button type="submit" class="btn btn-primary">{{trans('iforms::forms.form.submit')}}</button>
        </div>
    </form>

</div>
@include('iforms::frontend.form.mainlayout')
