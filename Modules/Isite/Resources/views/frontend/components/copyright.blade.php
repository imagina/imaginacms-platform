<p class="copyright">
  @if($withIconCopyright) <i class="fa-regular fa-copyright"></i> @endif
  @if($withTitleCopyright) {{trans('isite::copyright.title').' '}} @endif
  @if($withYear) {{$year.' '}} @endif
  @if($withSiteName) {{$name}} @endif
  @if($withLabelCopyright) {{trans('isite::copyright.text')}} @endif
</p>