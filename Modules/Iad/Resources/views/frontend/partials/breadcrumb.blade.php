<x-isite::breadcrumb>
  <li class="breadcrumb-item text-capitalize store-index" aria-current="page">
    @if(isset($category->id))
      <a href="{{tenant_route(request()->getHost(), \LaravelLocalization::getCurrentLocale() . '.iad.ad.index')}}">
        {{ trans('iad::routes.ad.index.index') }}
      </a>
    @else
      {{ trans('iad::routes.ad.index.index') }}
    @endif
  </li>
  @isset($categoryBreadcrumb)
    @foreach($categoryBreadcrumb as $key => $breadcrumb)
      <li
        class="breadcrumb-item category-index {{($key == count($categoryBreadcrumb)-1) ? 'category-index-selected' : ''}}"
        aria-current="page">
        @if($key == count($categoryBreadcrumb)-1 && !isset($product))
          {{ $breadcrumb->title }}
        @else
          <a href="{{$breadcrumb->url}}">{{ $breadcrumb->title }}</a>
        @endif
      </li>
    @endforeach
  @endif
  @if(isset($item->id))
    <li class="breadcrumb-item active" aria-current="page">{{$item->title}}</li>
  @endif
</x-isite::breadcrumb>

