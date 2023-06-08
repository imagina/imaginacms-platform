<x-isite::breadcrumb>
  @if(isset($page->id))
    <li class="breadcrumb-item active" aria-current="page">{{$page->title}}</li>
  @endif
</x-isite::breadcrumb>
