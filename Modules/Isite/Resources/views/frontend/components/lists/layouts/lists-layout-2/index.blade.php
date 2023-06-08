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
  <style>
    .lists-layout-2 {
      padding-top: 45px;
      padding-bottom: 30px;
    }
    .lists-layout-2 h3 {
      text-transform: uppercase;
      margin-bottom: 41px;
    }
    .lists-layout-2 .category-list-2__item {
      margin-bottom: 22px;
    }
    .lists-layout-2 .category-list-2__item figure {
      position: relative;
      height: 395px;
      margin: 0;
      overflow: hidden;
    }
    .lists-layout-2 .category-list-2__item figure:before {
      position: absolute;
      content: '';
      width: 100%;
      height: 100%;
      background-color: rgba(104, 77, 52, 0.32);
      z-index: 1;
    }
    .lists-layout-2 .category-list-2__item figure img {
      transition: all 0.5s;
    }
    .lists-layout-2 .category-list-2__item figure figcaption {
      position: absolute;
      left: 27px;
      bottom: 31px;
      z-index: 2;
    }
    .lists-layout-2 .category-list-2__item figure figcaption h2 {
      margin-bottom: 20px;
    }
    .lists-layout-2 .category-list-2__item figure figcaption .btn-custom {
      font-size: 1.125rem;
      margin-left: 15px;
    }
    .lists-layout-2 .category-list-2__item figure figcaption .btn-custom i {
      font-size: 1.25rem;
    }
    .lists-layout-2 .category-list-2__item figure:hover img, .lists-layout-2 .category-list-2__item figure:focus img {
      transform: scale(1.1);
    }

  </style>
</section>
