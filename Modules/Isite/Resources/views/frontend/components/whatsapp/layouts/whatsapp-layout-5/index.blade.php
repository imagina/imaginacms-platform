<div id="whatsappIconChatFixed" class="whatsapp-layout-5 whatsapp-fixed"
     style=" bottom:{{$bottom}}; left: {{$left}}; right: {{$right}}">
  @if($editButton == true)
    <x-isite::edit-link
      link="/iadmin/#/site/settings?module=isite&settings=whatsapp1,whatsapp2,whatsapp3"
      :tooltip="trans('isite::common.editLink.tooltipWhatsapp')"/>
  @endif
  @if(count($items) >= 1)
    <div class="pre-window">
      <div class="icon"><i class="fa fa-whatsapp"></i></div>
      <div class="text">{{trans('isite::common.whatsapp.labelWhatsappLayout5')}}</div>
    </div>

    <div class="window animate__animated animate__bounceOutDown">
      <div class="window-header">

        <div class="header-close"><i class="fa fa-close"></i></div>
        <div class="header-title"><i class="{{ $icon}}"></i> {{trans('isite::common.whatsapp.titleWhatsappLayout5')}} </div>
        <div class="header-text">{{trans('isite::common.whatsapp.descriptionWhatsappLayout5')}}</div>
      </div>
      <div class="window-content">
        <div class="scroll">
          @foreach($items as $key => $item)
            <a class="content-list"
               href="https://wa.me/{{ $item->callingCode }}{{ $item->number }}?text={{ $item->message }}"
               target="_blank">
              <div class="list-image">
                <div class="icon"><i class="{{ $item->iconLabel??$icon}}"></i></div>
              </div>
              <div class="list-info">
                <div class="title">{{ $item->label }}</div>
                <p class="subtitle">({{ $item->callingCode }}) {{ $item->number }}</p>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    </div>
  @endif
</div>
<script>
  $(function () {
    setTimeout(function () {
      $("#whatsappIconChatFixed").css('visibility', 'visible')
    }, 3000);

    $("#whatsappIconChatFixed .pre-window").click(function () {
      $("#whatsappIconChatFixed .window").removeClass('animate__bounceOutDown').addClass('animate__bounceInUp');
    });
    $("#whatsappIconChatFixed .header-close").click(function () {
      $("#whatsappIconChatFixed .window").removeClass('animate__bounceInUp').addClass('animate__bounceOutDown');

    });
  });
</script>