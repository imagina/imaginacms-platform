<div id="{{ $id }}" class="d-inline-block social-{{ $position }} position-relative {{$iconAnimate}}">
  <x-isite::edit-link
    link="/iadmin/#/site/settings?module=isite&group=socialNetworks"
    :tooltip="trans('isite::common.editLink.tooltipSocial')"
    top="-31px" left="-7px"
  />
  @foreach($items as $name=>$value)
    @if(!empty($value))
      <a href="{{ $value }}" target="_blank" aria-label="social {{ $type }} {{$name}}">
        @if($type)
          <span class="fa-stack fa-{{ $size }}">
          <i class="fa fa-{{ $type }} fa-stack-2x"></i>
          <i
            class="{{ $name }} fa-stack-1x @if($type=='square-o' || $type=='circle-thin' || empty($type))  @else text-white @endif"></i>
        </span>
        @else
          <i class="{{ $name }} fa-{{ $size }}"></i>
        @endif
      </a>
    @endif
  @endforeach
  @if($withWhatsapp)
    <x-isite::whatsapp :parentAttributes="$whatsappAttributes" layout="whatsapp-layout-2" :editButton="false"/>
  @endif
</div>
<style>
#{{$id}} > a {
    width: {{$iconBackgroundSize[0]}};
    height: {{$iconBackgroundSize[0]}};
}
#{{$id}} a:hover {
    text-decoration: none;
}
#{{$id}} .btn-group {
     vertical-align: initial;
}
#{{$id}} .whatsapp-layout-2 .number-whatsapp i {
     color: #06d755 !important;
     background-color: transparent;
     margin-right: 0;
     padding: 0;
}
@if($iconStyle=='1')
{{-- Icon con cada color y fondo blanco fijo --}}
#{{$id}} > a  i,
#{{$id}} > .whatsapp-layout-2 > a  i {
     display: {{$iconDisplay}};
     width: {{$iconBackgroundSize[0]}};
     height: {{$iconBackgroundSize[0]}};
     background: #ffffff;
     @if($iconBoxShadow[0]=='') box-shadow: 1px 1px 6px #ccc; @else box-shadow: {{$iconBoxShadow[0]}};  @endif
    @if($iconTextShadow[0]!='') text-shadow: {{$iconTextShadow[0]}}; @endif
    border-radius: {{$iconRadius}};
     align-items: center;
     justify-content: center;
     font-size: {{$iconSize[0]}};
     color: #6C6659;
     margin: {{$iconMargin}};
     position: relative;
     z-index: initial;
     transition: all ease 0.3s;
 }
#{{$id}} a:hover i {
    background-color: #6C6659;
    color: #ffffff;
    @if(count($iconBorderRadius)==2)
    border-radius: {{$iconRadiusHover}};
    @endif
    @if(count($iconBoxShadow)==2)
    box-shadow: {{$iconBoxShadow[1]}};
    @endif
    @if(count($iconTextShadow)==2)
    text-shadow: {{$iconTextShadow[1]}};
@endif
}
#{{$id}} > a  i.fa-facebook {
     color: #3B5998;
 }
#{{$id}} > a  i.fa-twitter {
     color: #2CC0FE;
 }
#{{$id}} > a  i.fa-instagram {
     color: #9339CA;
     background: -webkit-linear-gradient(125deg,#515bd4,#8134af, #dd2a7b,  #f58529);
     -webkit-background-clip: text;
     -webkit-text-fill-color: transparent;
 }
#{{$id}} > a  i.fa-skype {
     color: #00AFF0;
 }
#{{$id}} > a  i.fa-whatsapp,
#{{$id}} > .whatsapp-layout-2 > a  i.fa-whatsapp {
     color: #4DCC5B;
 }
#{{$id}} > a  i.fa-telegram {
     color: rgb(80,162,233);
 }
#{{$id}} > a  i.fa-youtube {
     color: #ff0000;
 }
#{{$id}} > a  i.fa-tiktok {
     color: black;
 }
#{{$id}} > a  i.fa-linkedin {
     color: #0a66c2;
 }
#{{$id}} > a  i.fa-flickr {
     color: #f70080;
 }
#{{$id}} > a  i.fa-pinterest {
     color: #d72f3b;
 }
#{{$id}} > a  i.fa-google {
     background: conic-gradient(from -45deg, #ea4335 110deg, #4285f4 90deg 180deg, #34a853 180deg 270deg, #fbbc05 270deg) 73% 55%/150% 150% no-repeat;
     -webkit-background-clip: text;
     background-clip: text;
     color: transparent;
     -webkit-text-fill-color: transparent;
}
#{{$id}} > a i:after,
#{{$id}} > .whatsapp-layout-2 > a i:after {
     content: '';
     background: #ffffff;
     position: absolute;
     width: 100%;
     height: 100%;
     z-index: -1;
     border-radius: {{$iconRadius}};
 }
#{{$id}} > a:hover i:after,
#{{$id}} > .whatsapp-layout-2 > a:hover i:after {
     background: transparent;
 }
#{{$id}} a:hover i.fa-youtube {
    color: #ffffff;
    background-color: #ff0000;
}
#{{$id}} > a:hover i.fa-facebook {
     color: #ffffff;
     background-color: #3B5998;
 }
#{{$id}} > a:hover i.fa-twitter {
     color: #ffffff;
     background-color: #2CC0FE;
 }
#{{$id}} > a:hover i.fa-instagram {
     color: #ffffff;
     background: linear-gradient(125deg,#515bd4,#8134af,#dd2a7b,#f58529);
     -webkit-text-fill-color: #ffffff;
 }
#{{$id}} > a:hover i.fa-skype {
     color: #ffffff;
     background-color: #00AFF0;
 }
#{{$id}} > a:hover i.fa-whatsapp,
#{{$id}} > .whatsapp-layout-2 > a:hover  i.fa-whatsapp {
     color: #ffffff;
     background-color: #4DCC5B;
 }
#{{$id}} > a:hover i.fa-telegram {
     color: #ffffff;
     background-color: rgb(80,162,233);
 }
#{{$id}} > a:hover i.fa-tiktok {
     color: #ffffff;
     background-color: black;
 }
#{{$id}} > a:hover  i.fa-linkedin {
     color: #ffffff;
     background-color: #0a66c2;
 }
#{{$id}} > a:hover  i.fa-flickr {
     color: #ffffff;
     background-color: #236ad0;
 }
#{{$id}} > a:hover  i.fa-pinterest {
     color: #ffffff;
     background-color: #d72f3b;
 }
#{{$id}} > a:hover  i.fa-google {
     background: conic-gradient(from -45deg, #ea4335 110deg, #4285f4 90deg 180deg, #34a853 180deg 270deg, #fbbc05 270deg) 73% 55%/150% 150% no-repeat;
     -webkit-background-clip: initial;
     color: #ffffff;
     -webkit-text-fill-color: #ffffff;
 }
@endif
@if($iconStyle=='2')
{{-- Icon con cada color(hover color1) y fondo fijo blanco (hover color 2) --}}
#{{$id}} > a  i,
#{{$id}} > .whatsapp-layout-2 > a  i {
    display: {{$iconDisplay}};
    width: {{$iconBackgroundSize[0]}};
    height: {{$iconBackgroundSize[0]}};
    background: #ffffff;
    @if($iconBoxShadow[0]!='') box-shadow: {{$iconBoxShadow[0]}}; @endif
    @if($iconTextShadow[0]!='') text-shadow: {{$iconTextShadow[0]}}; @endif
    border-radius: {{$iconRadius}};
    align-items: center;
    justify-content: center;
    font-size: {{$iconSize[0]}};
    color: #6C6659;
    margin: {{$iconMargin}};
    transition: all ease 0.5s;
    position: relative;
    z-index: initial;
}
#{{$id}} > a  i.fa-facebook {
    color: #3B5998;
}
#{{$id}} > a  i.fa-twitter {
    color: #2CC0FE;
}
#{{$id}} > a  i.fa-instagram {
    color: #9339CA;
    background: -webkit-linear-gradient(125deg,#515bd4,#8134af, #dd2a7b,  #f58529);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
#{{$id}} > a  i.fa-skype {
    color: #00AFF0;
}
#{{$id}} > a  i.fa-whatsapp,
#{{$id}} > .whatsapp-layout-2 > a  i.fa-whatsapp {
    color: #4DCC5B;
}
#{{$id}} > a  i.fa-telegram {
    color: rgb(80,162,233);
}
#{{$id}} > a  i.fa-youtube {
    color: #c00;
}
#{{$id}} > a  i.fa-tiktok {
    color: #000000;
}
#{{$id}} > a  i.fa-linkedin {
    color: #0a66c2;
}
#{{$id}} > a  i.fa-flickr {
    color: #f70080;
}
#{{$id}} > a  i.fa-pinterest {
    color: #d72f3b;
}
#{{$id}} > a  i.fa-google {
    background: conic-gradient(from -45deg, #ea4335 110deg, #4285f4 90deg 180deg, #34a853 180deg 270deg, #fbbc05 270deg) 73% 55%/150% 150% no-repeat;
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    -webkit-text-fill-color: transparent;
}
#{{$id}} > a i:after,
#{{$id}} > .whatsapp-layout-2 > a i:after {
     content: '';
     background: #ffffff;
     position: absolute;
     width: 100%;
     height: 100%;
     z-index: -1;
     border-radius: {{$iconRadius}};
}
#{{$id}} a:hover i {
    background: {{$iconColor2}};
    color: {{$iconColor1}};
    -webkit-text-fill-color: {{$iconColor1}};
    @if(count($iconBoxShadow)==2)
    box-shadow: {{$iconBoxShadow[1]}};
    @endif
    @if(count($iconTextShadow)==2)
    text-shadow: {{$iconTextShadow[1]}};
    @endif
    @if(count($iconBorderRadius)==2)
    border-radius: {{$iconRadiusHover}};
    @endif
}
@endif
@if($iconStyle=='3')
{{-- fondo color transparent icon (color1) icon hover (color2)--}}
#{{$id}} > a  i,
#{{$id}} > .whatsapp-layout-2 > a  i {
     display: {{$iconDisplay}};
     width: {{$iconBackgroundSize[0]}};
     height: {{$iconBackgroundSize[0]}};
     background-color: transparent;
     border-radius: {{$iconRadius}};
     @if($iconBoxShadow[0]!='') box-shadow: {{$iconBoxShadow[0]}}; @endif
     @if($iconTextShadow[0]!='') text-shadow: {{$iconTextShadow[0]}}; @endif
     align-items: center;
     justify-content: center;
     font-size: {{$iconSize[0]}};
     color: {{$iconColor1}};
     border-width: {{$iconBorderWidth}}px;
     border-style: solid;
     border-color: {{$iconColor1}};
     margin: {{$iconMargin}};
     transition: all ease 0.5s;
 }
#{{$id}} > a:hover  i,
#{{$id}} > .whatsapp-layout-2 > a:hover  i {
    color:  {{$iconColor2}};
    border-color: {{$iconColor2}};
    @if(count($iconBoxShadow)==2)
    box-shadow: {{$iconBoxShadow[1]}};
    @endif
    @if(count($iconTextShadow)==2)
    text-shadow: {{$iconTextShadow[1]}};
    @endif
    @if(count($iconBorderRadius)==2)
    border-radius: {{$iconRadiusHover}};
    @endif
}
@endif
@if($iconStyle=='4')
{{-- Icon color1 igual y fondo con color2 --}}
#{{$id}} > a i,
#{{$id}} > .whatsapp-layout-2 > a i {
     display: {{$iconDisplay}};
     width: {{$iconBackgroundSize[0]}};
     height: {{$iconBackgroundSize[0]}};
     background-color: {{$iconColor2}};
     border-radius: {{$iconRadius}};
     @if($iconBoxShadow[0]!='') box-shadow: {{$iconBoxShadow[0]}}; @endif
     @if($iconTextShadow[0]!='') text-shadow: {{$iconTextShadow[0]}}; @endif
     align-items: center;
     justify-content: center;
     font-size: {{$iconSize[0]}};
     color: {{$iconColor1}};
     border-width: {{$iconBorderWidth}}px;
     border-style: solid;
     border-color: {{$iconColor1}};
     margin: {{$iconMargin}};
     transition: all 0.2s linear 0s;
     position: relative;
     z-index: 1;
}
#{{$id}} > a:hover i,
#{{$id}} > .whatsapp-layout-2 > a:hover i  {
    color:  {{$iconColor2=="" ? '#ffffff' : $iconColor2}};
    border-color: {{$iconColor2}};
    background-color: {{$iconColor1}};
    @if(count($iconBorderRadius)==2)
    border-radius: {{$iconRadiusHover}};
    @endif
    @if(count($iconBoxShadow)==2)
    box-shadow: {{$iconBoxShadow[1]}};
    @endif
    @if(count($iconTextShadow)==2)
    text-shadow: {{$iconTextShadow[1]}};
    @endif
}
@if($iconAnimate=='background-top')
#{{$id}} > a  i,
#{{$id}} > .whatsapp-layout-2 > a  i {
     overflow: hidden;
 }
#{{$id}} > a i:after,
#{{$id}} > .whatsapp-layout-2 > a i:after  {
     content: '';
     position: absolute;
     top: 100%;
     left: 0;
     right: 0;
     transition: all 0.2s linear 0s;
     border-color: {{$iconColor2}};
     background-color: {{$iconColor1}};
     width: 100%;
     height: 100%;
     margin: 0 auto;
     z-index: -1;
 }
#{{$id}} > a:hover  i:after,
#{{$id}} > .whatsapp-layout-2 > a:hover i:after  {
     top: 0;
     transition: all 0.2s linear 0s;
 }
@endif
@if($iconAnimate=='background-left')
#{{$id}} > a  i,
#{{$id}} > .whatsapp-layout-2 > a  i {
     overflow: hidden;
 }
#{{$id}} > a  i:after,
#{{$id}} > .whatsapp-layout-2 > a i:after  {
     content: '';
     position: absolute;
     top: 0;
     right: 100%;
     transition: all 0.2s linear 0s;
     border-radius: {{$iconRadius}};
     border-color: {{$iconColor2}};
     background-color: {{$iconColor1}};
     width: 100%;
     height: 100%;
     margin: 0 auto;
     z-index: -1;
 }
#{{$id}} > a:hover  i:after,
#{{$id}} > .whatsapp-layout-2 > a:hover i:after  {
     right: 0;
     transition: all 0.2s linear 0s;
 }
@endif
@if($iconAnimate=='background-square')
#{{$id}} > a:hover  i,
#{{$id}} > .whatsapp-layout-2 > a:hover i  {
     box-shadow: none !important;
     text-shadow: none !important;
     border-width: 0 !important;
     background-color: transparent !important;
 }
#{{$id}} > a i:after,
#{{$id}} > .whatsapp-layout-2 > a i:after  {
     content: '';
     transform: rotate(0deg);
 }
#{{$id}} > a:hover  i:after,
#{{$id}} > .whatsapp-layout-2 > a:hover i:after  {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    border-width: {{$iconBorderWidth}}px;
    border-style: solid;
    border-color: {{$iconColor2}};
    background-color: {{$iconColor1}};
    width: 100%;
    height: 100%;
    margin: 0 auto;
    z-index: -1;
    @if(count($iconBoxShadow)==2)
    box-shadow: {{$iconBoxShadow[1]}};
    @endif
    @if(count($iconTextShadow)==2)
    text-shadow: {{$iconTextShadow[1]}};
    @endif
    transition: all 0.2s linear 0s;
    @if(count($iconBorderRadius)==2)
    border-radius: {{$iconRadiusHover}};
    @else
    border-radius: 0;
    @endif
    transform: rotate(45deg);
 }
@endif
@endif
@media (max-width: 767.98px) {
    #{{$id}} > a i {
        @if(count($iconSize)==2)
        font-size: {{$iconSize[1]}};
        @endif
        @if(count($iconBackgroundSize)==2)
        width: {{$iconBackgroundSize[1]}};
        height: {{$iconBackgroundSize[1]}};
        @endif
    }
    @if(count($iconBackgroundSize)==2)
    #{{$id}} > a i {
         width: {{$iconBackgroundSize[1]}};
         height: {{$iconBackgroundSize[1]}};
    }
    @endif
}
@if($iconAnimate=='scale-all')
#{{$id}}.scale-all > a:hover i,
#{{$id}}.scale-all > .whatsapp-layout-2 > a:hover i  {
    transform: scale(1.2);
}
@endif
@if($iconAnimate=='translate-top')
#{{$id}}.translate-top > a:hover i,
#{{$id}}.translate-top > .whatsapp-layout-2 > a:hover i  {
    transform: translateY(-5px);
}
@endif
@if($iconAnimate=='translate-bottom')
#{{$id}}.translate-bottom > a:hover i,
#{{$id}}.translate-bottom > .whatsapp-layout-2 > a:hover i  {
    transform: translateY(5px);
}
@endif
@if($iconAnimate=='translate-left')
#{{$id}}.translate-left > a:hover i,
#{{$id}}.translate-left > .whatsapp-layout-2 > a:hover i  {
    transform: translateX(-5px);
}
@endif
@if($iconAnimate=='translate-right')
#{{$id}}.translate-right > a:hover i,
#{{$id}}.translate-right > .whatsapp-layout-2 > a:hover i {
    transform: translateX(5px);
}
@endif
</style>
