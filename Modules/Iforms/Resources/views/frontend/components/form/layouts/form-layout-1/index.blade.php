<div id="loading-form">
  <div class="lds-spinner">
    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
</div>
<div id="formLayout1" class="content-form{{$formId}} position-relative">
  @if($withTitle)
    <div class="title-section {{$colorTitleByClass}} {{$AlainTitle}}">
      {{$title}}
    </div>
  @endif
  @if($withSubtitle)
    <div class="subtitle-section {{$colorSubtitleByClass}} {{$AlainSubtitle}}">
      {{$subtitle}}
    </div>
  @endif
  <x-isite::edit-link link="/iadmin/#/form/fields/{{$form->id}}"
                      :tooltip="trans('iforms::common.editLink.tooltipForm')"/>
  <div class="formerror"></div>
  <form id="{{$formId}}" class="form-horizontal  overflow-hidden" method="post" action="{{route('api.iforms.leads.create')}}">
    <input type="hidden" name="form_id" value="{{$form->id}}" required="">

  @include('iforms::frontend.components.form.layouts.form-layout-1.fields')
  <!--Validate field terms and conditions-->
  @if(isset($form->options->urlTermsAndConditions))
    <!--Content Terms and Conditions -->
      <div id="contentTermsAndConditions" class="col-12 position-relative mb-3">
        <div id="CheckFormTermsAndConditions" class="pl-4">
          <input type="checkbox" class="form-check-input" required="" id="TermsAndConditions">
          <label class="form-check-label h6" for="TermsAndConditions">
            {!! trans('iforms::forms.form.termsAndConditions', ['urlTermsAndConditions' =>$form->options->urlTermsAndConditions]) !!}
          </label>
        </div>
      </div>
    @endif

    <div class="col-12">
      <x-isite::captcha :formId="$formId"/>
    </div>

    <div class="form-group row mb-0">
      <div class="col-sm-12 text-right">
        <button type="submit"
                class="btn btn-primary">{{ $form->submit_text ?? trans('iforms::forms.form.submit')}}</button>
      </div>
    </div>
  </form>
</div>
@include('iforms::frontend.components.form.layouts.mainlayout')

<style>
    #formLayout1 .title-section {
        color: {{$colorTitle}};
        font-size: {{$fontSizeTitle}}px;
    }
    #formLayout1 .subtitle-section {
        color: {{$colorSubtitle}};
        font-size: {{$fontSizeSubtitle}}px;
    }
    #formLayout1 .form-group .col-style {
        margin-bottom: 10px;
    }
</style>
