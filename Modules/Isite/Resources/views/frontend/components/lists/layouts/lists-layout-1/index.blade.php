<section id="{{ $id }}" class="{{ $class }} lists-layout-1">
  <div class="container-fluid px-0">
    <div class="row no-gutters">
        @foreach($items as $item)
        <div class="col-12 col-md-4">
            <div class="card h-100 card-overlay rounded border-0">
                <a href="{{$item->url}}" class="position-relative" style="background-image: url('{{$item->mediaFiles()->mainimage->path}}')">
                    <div class="card-img-overlay">
                        <h3 class="card-title text-white mb-1">{{ $item->title ?? $item->name ?? $item->label }}</h3>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
  </div>
</section>
