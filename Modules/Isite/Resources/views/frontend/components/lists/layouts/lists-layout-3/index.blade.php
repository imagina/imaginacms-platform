<section id="{{ $id }}" class="{{ $class }} lists-layout-3">
  <div class="container">
    <div class="row">
      @foreach($items as $key => $item)
        @if($key > 2) @php continue; @endphp @endif
        @if($item->status)
          @if($key!=2)
            <div class="col-12 col-lg-6">
          @endif
          @if($key != 0)
            <div class="row">
          @endif

          <!-- Single Category -->
          <div class="col-12 {{$key ==0 ? "first-category" : "other-category" }}">
            <div id="{{ $item->title }}" class="items">
              <div class="card h-100 card-overlay rounded border-0">
                <a href="{{$item->url}}" class="position-relative h-100 imagen">
                  <img src="{{$item->mediaFiles()->mainimage->path}}" class="img-fluid lazyload"
                       alt="{{$item->title}}">
                </a>
                <div class="card-img-overlay">
                  <h3 class="card-title text-white mb-1">{{$item->title}}</h3>
                  <a class="btn border-0" href="{{$item->url}}">{{ $buttonTitle }}</a>
                </div>
              </div>
            </div>
          </div>

          @if($key != 0)
            <!-- close row -->
            </div>
          @endif
          @if($key!=1)
            <!-- close col-12 col-lg-6 -->
            </div>
          @endif
        @endif
      @endforeach
    </div>
  </div>
</section>
