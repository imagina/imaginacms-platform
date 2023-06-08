<div id="whatsappImageFixed" class="whatsapp-layout-3 whatsapp-fixed">
  <div class="content-whatsapp">
    <div class="rotate">
      @if($editButton == true)
        <x-isite::edit-link
          link="/iadmin/#/site/settings?module=isite&settings=whatsapp1,whatsapp2,whatsapp3"
          :tooltip="trans('isite::common.editLink.tooltipWhatsapp')"/>
      @endif
      <a @if(count($items)>1)
         id="dropdownImgWhatsapp" role="button" class="{{ count($parentAttributes) > 0 ? ' p-0' : '' }}" data-toggle="dropdown"
         aria-haspopup="true" aria-expanded="false" aria-label="dropdown img whatsapp"
         @else @php($item = $items[0]) href="https://wa.me/{{ $item->callingCode }}{{ $item->number }}?text={{ $item->message }}"
         class="whatsapp-link-layout-2" target="_blank"
        @endif>
        <img id="whatsappimageText" src="/modules/isite/img/whatsapp-text.png" alt="WhatsappimageText">
      </a>
      <x-isite::whatsapp layout="whatsapp-layout-2" icon="{{$icon}}" alignment="{{$alignment}}"
                         dropdownTextAlign="{{$dropdownTextAlign}}" infoSubtitleColor="{{$infoSubtitleColor}}"
                         infoTitleColor="{{$infoTitleColor}}"
                         size="{{ $size }}" notNumber="{{$notNumber}}" :editButton="false"/>
    </div>
  </div>
</div>
<style>
#whatsappImageFixed {
    top:{{$top ?? '50%'}};
    bottom:{{$bottom ?? 'unset'}};
    left: {{$left ?? '0'}};
    right: {{$right ?? 'unset'}};
    position: fixed;
    z-index: 1037;
    background: #06d755;
    width: 39px;
    height: 137px;
    color: #ffffff;
}
#whatsappImageFixed .content-whatsapp {
    position: relative;
}
#whatsappImageFixed .content-whatsapp .dropright,
#whatsappImageFixed .content-whatsapp .dropleft {
    padding: 0;
    position: relative;
    bottom: -37px;
}
#whatsappImageFixed .content-whatsapp .dropright #dropdownMenuWhatsapp,
#whatsappImageFixed .content-whatsapp .dropleft #dropdownMenuWhatsapp {
    padding: 7px;
    cursor: pointer;
}
#whatsappImageFixed .content-whatsapp .dropright #dropdownMenuWhatsapp:before,
#whatsappImageFixed .content-whatsapp .dropleft #dropdownMenuWhatsapp:before {
    display: none;
}
#whatsappImageFixed .content-whatsapp .dropright .dropdown-menu-whatsapp,
#whatsappImageFixed .content-whatsapp .dropleft .dropdown-menu-whatsapp {
    top: -10px !important;
}
#whatsappImageFixed #whatsappimageText {
    transform: rotate(-90deg);
    margin-top: 43px;
    margin-left: -18px;
    width: 78px;
    height: 15px;
}
#whatsappImageFixed  a.whatsapp-layout-2 .icon-whatsapp{
    position: relative;
    bottom: -43px;
    left: 7px;
}
#whatsappImageFixed .icon-whatsapp {
    color: #fff;
    font-size: 27px;
}
</style>



