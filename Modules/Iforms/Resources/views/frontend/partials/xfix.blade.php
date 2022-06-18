@if(!empty($xfix))
  @if(!empty($xfix->text))
    <div class="@if($type == "pre") input-group-prepend @else input-group-append @endif">
      <span class="input-group-text bg-transparent @if($type == "pre") border-right-0 @else border-left-0 @endif  text-primary">
        @if($xfix->type=='icon')
          <i class="text-primary {{ $xfix->text }}"></i>
        @else
          {{ $xfix->text }}
        @endif
      </span>
    </div>
  @endif
@endif
