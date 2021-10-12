<div id="whatsappImageFixed" class="whatsapp-layout-3 whatsapp-fixed"
     style="top:{{$top}}; bottom:{{$bottom}}; left: {{$left}}; right: {{$right}}">
  <div class="content-whatsapp">
    <div class="rotate">
      @if($editButton == true)
        <x-isite::edit-link
          link="/iadmin/#/site/settings?module=isite&settings=whatsapp1,whatsapp2,whatsapp3"
          :tooltip="trans('isite::common.editLink.tooltipWhatsapp')"/>
      @endif
      <a @if(count($items)>1)
         id="dropdownMenuWhatsapp" class="{{ count($parentAttributes) > 0 ? ' p-0' : '' }}" data-toggle="dropdown"
         aria-haspopup="true" aria-expanded="false" style="cursor: pointer"
         @else @php($item = $items[0]) href="https://wa.me/{{ $item->callingCode }}{{ $item->number }}?text={{ $item->message }}"
         class="whatsapp-link-layout-2" target="_blank"
        @endif>
        <img id="WhatsappimageText" src="/modules/isite/img/whatsapp-text.png" alt="WhatsappimageText">
      </a>
      <x-isite::whatsapp layout="whatsapp-layout-2" icon="{{$icon}}" alignment="{{$alignment}}"
                         size="{{ $size }}" notNumber="{{$notNumber}}" :editButton="false"/>
    </div>
  </div>
</div>
