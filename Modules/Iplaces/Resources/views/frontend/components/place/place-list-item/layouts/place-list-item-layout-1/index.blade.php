<div class="place-layout place-item-layout-1 position-relative">
    <x-isite::edit-link link="{{$editLink}}{{$item->id}}" tooltip="{{$tooltipEditLink}}"/>
  <a href="{{$item->url}}"><h4>{{$item->title}}</h4></a>
  @if(isset($item->options->addressIplace) && !empty($item->options->addressIplace))
    <x-isite::contact.addresses :addresses="$item->options->addressIplace"/>
  @endif
  <x-isite::contact.phones :phones="$phones"/>

  <x-isite::whatsapp :numbers="$whatsappNumbers"/>

</div>

