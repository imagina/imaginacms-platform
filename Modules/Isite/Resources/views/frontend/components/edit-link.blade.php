@if($canAccess)
  <div {{$idButton ? 'id=".$idButton."' : ''}} class="editLink position-absolute  {{$classes}}"
       style="top:{{$top}}; bottom:{{$bottom}}; left: {{$left}}; right: {{$right}}; z-index:999">
    <a id="buttonEditLink" class="btn btn-sm text-white" href="{{url($link)}}" target="_blank" data-toggle="tooltip"
       title="{{$tooltip}}">
      <i class="fa fa-pencil text-white"></i><span> | {{trans("isite::common.editLink.buttonEdit")}}</span>
    </a>
  </div>
@endif