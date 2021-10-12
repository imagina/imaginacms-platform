<section id="{{ $id }}" class="{{ $class }} lists-layout-2 container-fluid">
  <div class="row mx-0">
  @foreach($items as $index => $item)
    @if($item->status)
      @php
        if ($index != 2 && $index != 3) {
           $col = 'col-md-6';
        } elseif ($index == 2) {
           $col = 'col-md-7';
        } elseif ($index == 3) {
           $col = 'col-md-5';
        }
      @endphp

      <div class="{{$col}} category-list-2__item position-relative">
        <a href="{{$item->url}}">
          <figure>
            <img class="cover-img lazyload" src="{!! $item->mediaFiles()->mainimage->path !!}" alt="{{$item->title}}">

            <figcaption>
              <h2 class="text-white">{{$item->title ?? $item->name}}</h2>

              <button class="btn-custom text-center text-white text-uppercase bg-transparent border-0"
                      type="button">
                <i class="fa fa-arrow-circle-right mr-1" aria-hidden="true"></i>
                {{ $buttonTitle }}
              </button>
            </figcaption>
          </figure>
        </a>
      </div>
   @endif
  @endforeach
  </div>
</section>
