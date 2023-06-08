<div id="whatsappIconChatFixed" class="whatsapp-layout-5 whatsapp-fixed">
  @if($editButton == true)
    <x-isite::edit-link
      link="/iadmin/#/site/settings?module=isite&settings=whatsapp1,whatsapp2,whatsapp3"
      :tooltip="trans('isite::common.editLink.tooltipWhatsapp')"/>
  @endif
  @if(count($items) >= 1)
    <div class="pre-window {{$alignmentMsn ?? ''}}">
      <div class="icon"><i class="fa fa-whatsapp"></i></div>
      <div class="text">{{$title=="" ? trans('isite::common.whatsapp.labelWhatsappLayout5') : $title}}</div>
    </div>

    <div class="window animate__animated animate__bounceOutDown {{$alignmentWin ?? ''}}">
      <div class="window-header">

        <div class="header-close"><i class="fa fa-close"></i></div>
        <div class="header-title"><i class="{{ $icon}}"></i> {{$titleInternal=="" ? trans('isite::common.whatsapp.titleWhatsappLayout5') : $titleInternal}}</div>
        <div class="header-text">{{$summaryInternal=="" ? trans('isite::common.whatsapp.descriptionWhatsappLayout5') : $summaryInternal}}</div>
      </div>
      <div class="window-content">
        <div class="scroll">
          @foreach($items as $key => $item)
            <a class="content-list text-decoration-none"
               href="https://wa.me/{{ $item->callingCode }}{{ $item->number }}?text={{ $item->message }}"
               target="_blank" aria-label="whatsapp">
              <div class="list-image">
                <div class="icon"><i class="{{$item->iconLabel=="" ? $icon : $item->iconLabel}}"></i></div>
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
<style>
#whatsappIconChatFixed {
    visibility: hidden;
}
#whatsappIconChatFixed .pre-window {
    display: flex;
    align-items: center;
    z-index: 1037;
    bottom:{{$bottom ?? '40px'}};
    left: {{$left ?? '40px'}};
    right: {{$right ?? 'unset'}};
    position: fixed;

}
#whatsappIconChatFixed .pre-window .icon {
    width: 54px;
    height: 54px;
    background-color: #22ce5a;
    color: #ffffff;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 33px;
    cursor: pointer;
}
#whatsappIconChatFixed .pre-window .text {
    background-color: #F6F6F6;
    padding: 8px 20px;
    margin-left: 25px;
    border-radius: 10px;
    color: var(--primary);
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    border: 2px solid #E9E9E9;
    position: relative;
}
#whatsappIconChatFixed .pre-window .text:before {
     position: absolute;
     content: '';
     left: -16px;
     top: 50%;
     transform: translateY(-50%);
     border-top: 8px solid transparent;
     border-bottom: 8px solid transparent;
     border-right: 16px solid #E9E9E9;
 }
#whatsappIconChatFixed .pre-window .text:after {
     position: absolute;
     content: '';
     left: -11px;
     top: 50%;
     transform: translateY(-50%);
     border-top: 8px solid transparent;
     border-bottom: 8px solid transparent;
     border-right: 14px solid #f6f6f6;
}
#whatsappIconChatFixed .pre-window.right .icon {
    order: 1;
}
#whatsappIconChatFixed .pre-window.right .text {
    margin-right: 25px;
}
#whatsappIconChatFixed .pre-window.no-text .text {
    display: none;
}
#whatsappIconChatFixed .pre-window.right .text:before {
    left: unset;
    right: -16px;
    border-left: 16px solid #E9E9E9;
    border-right: 0;
}
#whatsappIconChatFixed .pre-window.right .text:after {
    left: unset;
    right: -11px;
    border-left: 14px solid #f6f6f6;
    border-right: 0;
}
#whatsappIconChatFixed .window {
    position: fixed;
    z-index: 99999;
    box-shadow: 0 0 30px rgb(0 0 0 / 30%);
    background-color: #F6F6F6;
    overflow: hidden;
    width: 350px;
    font-family: inherit;
    font-size: 14px;
    line-height: 1.4;
    bottom: 20px;
    display: block;
    border-radius: 20px;
    left: 40px;
}
#whatsappIconChatFixed .window.right {
    left: unset;
    right: 40px;
}
#whatsappIconChatFixed .window .window-header {
    background-color: var(--primary);
    color: #fff;
    padding: 26px;
    position: relative;
}
#whatsappIconChatFixed .window .window-header .header-close {
    float: right;
    width: 17px;
    height: 17px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}
#whatsappIconChatFixed .window .window-header .header-close:hover {
    cursor: pointer;
    filter: drop-shadow(0px 0px 10px #000);
}
#whatsappIconChatFixed .window .window-header .header-title {
    font-weight: normal;
    font-size: 20px;
    line-height: 100%;
    margin-bottom: 8px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
#whatsappIconChatFixed .window .window-header .header-text {
    font-weight: normal;
    font-size: 16px;
    line-height: 100%;
    color: #EFEFEF;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    margin-left: 25px;
}
#whatsappIconChatFixed .window .window-content {
    padding: 0;
    background-color: #F6F6F6;
    height: 297px;
    overflow-y: auto;
}
#whatsappIconChatFixed .window .window-content .content-list {
    font-size: 13px;
    padding: 21px 30px;
    overflow: hidden;
    border-bottom: 2px solid #E9E9E9;
    display: flex;
    background-color: #F6F6F6;
    cursor: pointer;
    align-items: center;
}
#whatsappIconChatFixed .window .window-content .content-list .list-image {
    position: relative;
    margin-right: 10px;
}
#whatsappIconChatFixed .window .window-content .content-list .list-image .icon {
    height: 55px;
    width: 55px;
    background-color: var(--primary);
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    font-size: 33px;
}
#whatsappIconChatFixed .window .window-content .content-list .list-info .title {
    display: block;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 0.1em;
    color: {{$infoTitleColor}};
}
#whatsappIconChatFixed .window .window-content .content-list .list-info .subtitle {
    margin: 0;
    padding: 0;
    line-height: 1;
    color: {{$infoSubtitleColor}};
    font-weight: 500;
    font-size: 15px;
}
@media screen and (max-width: 576px) {
    #whatsappIconChatFixed .window {
        top: 0;
        left: 0 !important;
        right: 0 !important;
        bottom: 0;
        width: 100%;
        max-width: 100%;
        border-radius: 0;
    }
    #whatsappIconChatFixed .window .chat-content {
        max-height: 90%;
        height: calc(100vh - 100px) !important;
    }

}
#whatsappIconChatFixed .scroll {
    overflow:auto;
    height: 100%;
    scrollbar-color: rgba(0, 0, 0, .5) rgba(0, 0, 0, 0);
    scrollbar-width: thin;
    margin-right: 3px;
}
#whatsappIconChatFixed .scroll::-webkit-scrollbar {
    -webkit-appearance: none;
}
#whatsappIconChatFixed .scroll::-webkit-scrollbar:vertical {
    width:5px;
}
#whatsappIconChatFixed .scroll::-webkit-scrollbar-button:increment,.scroll::-webkit-scrollbar-button {
    display: none;
}
#whatsappIconChatFixed .scroll::-webkit-scrollbar:horizontal {
    height: 10px;
}
#whatsappIconChatFixed .scroll::-webkit-scrollbar-thumb {
    background-color: #DBDBDB;
    border-radius: 0;
    border: 1px solid #DBDBDB;
}
#whatsappIconChatFixed .scroll::-webkit-scrollbar-track {
    border-radius: 0;
}
</style>
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