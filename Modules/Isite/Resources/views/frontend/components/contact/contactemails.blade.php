@if(!empty($emails))
  <!--emails content-->
  <div id="componentContactEmails" class="position-relative">
    <x-isite::edit-link
      link="/iadmin/#/site/settings?module=isite&settings=emails"
      :tooltip="trans('isite::common.editLink.tooltipEmail')"/>
    <div class="d-flex">
      <!--icon-->
      @if($showIcon)
        <i class="{{$icon}} align-self-center mr-2"></i>
      @endif
      <div class="content-email">
        @foreach($emails as $key => $email)
          @if($key > 0) - @endif
        <!--email-->
          <a class="d-inline-block" href="mailto:{{$email}}">{{$email}}</a>
        @endforeach
      </div>
    </div>
  </div>
@endif
