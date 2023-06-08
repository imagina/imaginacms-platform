<div id="whatsappIconFixed" class="whatsapp-layout-4 whatsapp-fixed">
  <div class="rotate">
    <div class="content-background position-relative">
      @if($editButton == true)
        <x-isite::edit-link
          link="/iadmin/#/site/settings?module=isite&settings=whatsapp1,whatsapp2,whatsapp3"
          :tooltip="trans('isite::common.editLink.tooltipWhatsapp')"
          top="-48px"
        />
      @endif
      <x-isite::whatsapp layout="whatsapp-layout-2" icon="{{$icon}}" alignment="{{$alignment}}" size="{{ $size }}"
                         dropdownTextAlign="{{$dropdownTextAlign}}" infoSubtitleColor="{{$infoSubtitleColor}}"
                         infoTitleColor="{{$infoTitleColor}}"
                         notNumber="{{$notNumber}}" notShow="true" :editButton="false"/>
    </div>
  </div>
</div>
<style>
#whatsappIconFixed {
    top:{{$top ?? '25%'}};
    bottom:{{$bottom ?? 'unset'}};
    left: {{$left ?? 'unset'}};
    right: {{$right ?? '10px'}};
    position: fixed;
    z-index: 1037;
}
#whatsappIconFixed .dropdown-menu-whatsapp {
    top: 11px !important;
}
#whatsappIconFixed .content-background {
    color: white;
    background-color: #06d755;
    align-items: center;
    display: flex;
    font-size: 29px;
    width: 60px;
    height: 60px;
    box-shadow: 2px 2px 12px #aaa;
    border-radius: 48%;
}
#whatsappIconFixed .content-background a {
    margin: 0 auto;
}
#whatsappIconFixed .icon-whatsapp {
    color: #ffffff;
    font-size: 40px;
    margin-top: 20px;
}
#whatsappIconFixed #dropdownMenuWhatsapp .icon-whatsapp {
    margin-top: 15px;
}
</style>