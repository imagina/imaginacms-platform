<div id="formLayout3" class="content-form{{$formId}} position-relative">
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
  <div class="formerror"></div>
    <x-isite::edit-link link="/iadmin/#/form/fields/{{$form->id}}"
                        :tooltip="trans('iforms::common.editLink.tooltipForm')"/>
  <form id="{{$formId}}" class="form-horizontal overflow-hidden" action="{{route('api.iforms.leads.create')}}">
    <input type="hidden" name="form_id" value="{{$form->id}}" required="">

    @include('iforms::frontend.components.form.layouts.form-layout-3.fields')
    <div class="col-sm-12">
      <x-isite::captcha :formId="$formId"/>
    </div>
    <div class="w-100 text-right">
      <button type="submit"
              class="btn btn-primary">{{ $form->submit_text ?? trans('iforms::forms.form.submit')}}</button>
    </div>
  </form>
</div>
@include('iforms::frontend.components.form.layouts.mainlayout')

<style>
    #formLayout3 .title-section {
        color: {{$colorTitle}};
        font-size: {{$fontSizeTitle}}px;
    }
    #formLayout3 .subtitle-section {
        color: {{$colorSubtitle}};
        font-size: {{$fontSizeSubtitle}}px;
    }
    #formLayout3 .form-group .col-style {
        margin-bottom: 10px;
    }
</style>