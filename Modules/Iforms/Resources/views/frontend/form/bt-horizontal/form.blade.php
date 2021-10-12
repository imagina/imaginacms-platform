@php
  $id=Str::slug($form->system_name).$options['rand'];
@endphp
<div id="loading-form">
  <div class="lds-spinner">
    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
</div>
<div class="content-form{{$options['rand']}}">
  <div class="formerror"></div>
  <form id="{{$id}}" class="form-horizontal" method="post" action="{{route('api.iforms.leads.create')}}">
    <input type="hidden" name="form_id" value="{{$form->id}}" required="">

    @include('iforms::frontend.form.bt-horizontal.fields')
    <!--Validate field terms and conditions-->
    @if((isset($form->options->urlTermsAndConditions)) && ($form->options->urlTermsAndConditions))
      <!--Content Terms and Conditions -->
      <div id="contentTermsAndConditions" class="col-12 position-relative">
        <div id="CheckFormTermsAndConditions" class="pl-4">
          <input type="checkbox" class="form-check-input" required="" id="TermsAndConditions">
          <label class="form-check-label h6" for="TermsAndConditions">{{trans('iforms::forms.form.accept')}}
            <a href="{{$form->options->urlTermsAndConditions}}" class="h6">
              {{trans('iforms::forms.form.termsAndsConditions')}}
            </a>
          </label>
        </div>
      </div>
    @endif

    <div class="col-sm-offset-2 col-sm-10">
      @if(Setting::get('iforms::api'))
        {!!app('captcha')->display($attributes = ['data-sitekey'=>Setting::get('iforms::api')])!!}
      @endif
      </br>
    </div>

    <div class="form-group row">
      <div class="col-sm-12 text-right">
        <button type="submit" class="btn btn-primary">{{trans('iforms::forms.form.submit')}}</button>
      </div>
    </div>
  </form>
</div>
@include('iforms::frontend.form.mainlayout')
