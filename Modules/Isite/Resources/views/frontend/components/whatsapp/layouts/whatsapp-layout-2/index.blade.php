<!--Validation to show icon or dropdown -->
@if(count($items) <= 1)
  @foreach($items as $key => $item)
    @if($editButton == true)
      <div class="position-relative">
        <x-isite::edit-link
          link="/iadmin/#/site/settings?module=isite&settings=whatsapp1,whatsapp2,whatsapp3"
          :tooltip="trans('isite::common.editLink.tooltipWhatsapp')"
          top="-3px" left="42px"/>
      </div>
    @endif
    <a href="https://wa.me/{{ $item->callingCode }}{{ $item->number }}?text={{ $item->message }}"
       class="whatsapp-layout-2 position-relative" target="_blank">
      @if($type)
        <span class="fa-stack fa-{{ $size }}">
          <i class="fa fa-{{ $type }} fa-stack-2x"></i>
          <i
            class="icon-whatsapp {{ $icon }} fa-stack-1x @if($type=='square-o' || $type=='circle-thin' || empty($type))  @else text-white @endif"></i>
        </span>
      @else
        <i class="icon-whatsapp {{ $icon }} fa-{{ $size }}"></i>
      @endif
    </a>
  @endforeach
@else
  <div class="btn-group {{$alignment}} whatsapp-layout-2 position-relative">
    @if($editButton == true)
      <x-isite::edit-link
        link="/iadmin/#/site/settings?module=isite&settings=whatsapp1,whatsapp2,whatsapp3"
        :tooltip="trans('isite::common.editLink.tooltipWhatsapp')"
        top="3px" left="37px"/>
    @endif
    <a id="dropdownMenuWhatsapp" type="button"
       class="btn dropdown-toggle{{ count($parentAttributes) > 0 ? ' p-0' : '' }}" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false">
      @if($type)
        <span class="fa-stack fa-{{ $size }}">
          <i class="fa fa-{{ $type }} fa-stack-2x"></i>
          <i
            class="icon-whatsapp {{ $icon }} fa-stack-1x @if($type=='square-o' || $type=='circle-thin' || empty($type))  @else text-white @endif"></i>
        </span>
      @else
        <i class="icon-whatsapp {{ $icon }} fa-{{ $size }}"></i>
      @endif
    </a>
    <div class="dropdown-menu dropdown-menu-whatsapp">
      <!-- Dropdown menu links -->
      @foreach($items as $key => $item)
        @if(!empty($item->callingCode) && !empty($item->number))
          <div class="number-whatsapp">
            <a href="https://wa.me/{{ $item->callingCode }}{{ $item->number }}?text={{ $item->message }}"
               target="_blank">
              <p class="mb-0">
                @if(isset($item->iconLabel) && !empty($item->iconLabel))
                  <i class="{{ $item->iconLabel}} "></i>
                @endif
                <span>{{ isset($item->label) ? $item->label.'' :'' }}</span>
              </p>
              @if($notNumber == true)
                <p class="mb-0 formatted-number">
                  <span>{{ $item->formattedNumber }}</span>
                </p>
              @endif
            </a>
          </div>
        @endif
      @endforeach
    </div>
  </div>
@endif
