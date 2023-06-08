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
    <style>
        .lists-layout-1 .card a {
            height: calc(100vh *.72) !important;
            background-size: cover;
            background-repeat: no-repeat;
        }
        .lists-layout-1 .card h3 {
            font-size: 2.375rem;
        }
        .lists-layout-1 .card:hover {
            box-shadow: 0px 0px 9px 0px #949393;
            z-index: 9;
        }
        @media (min-width: 767.98px) {
            .lists-layout-1 .card h3 {
                font-size: 1.125rem;
            }
        }

    </style>
</section>
