@if(!empty($phones))
  <!--phone content-->
  <div id="componentContactPhones" class="position-relative {{$classes}}">
    <x-isite::edit-link
      link="/iadmin/#/site/settings?module=isite&settings=phones"
      :tooltip="trans('isite::common.editLink.tooltipPhone')"/>
    <div class="d-flex">
      <!--icon-->
      @if($showIcon)
        <i class="{{$icon}} align-self-center mr-2"></i>
      @endif
      <div class="content-phone px-0">
        @foreach($phones as $key => $phone)
          @if($withHyphen) @if($key > 0)<span> - </span>@endif @endif
        <!--phone-->
          <a class="d-inline-block" href="tel:{{$phonesReplaced[$key]}}">{{$phone}}</a>
        @endforeach
      </div>
    </div>
  </div>
@endif
