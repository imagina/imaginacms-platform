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
    <style>
        .lists-layout-3 .first-category {
            padding-bottom: 40px;
            border-bottom: solid 1px #b4b4b4;
            margin-bottom: 40px;
        }
        @media (min-width: 991.98px) {
            .lists-layout-3 .first-category {
                padding-bottom: 20px;
                border-bottom: solid 1px #b4b4b4;
                margin-bottom: 20px;
            }
        }
        .lists-layout-3 .first-category .items {
            height: 880px;
        }
        @media (min-width: 991.98px) {
            .lists-layout-3 .first-category .items {
                height: 400px;
            }
        }
        .lists-layout-3 .other-category .items {
            height: 400px;
        }
        .lists-layout-3 .other-category:first-child {
            padding-bottom: 40px;
            border-bottom: solid 1px #b4b4b4;
            margin-bottom: 40px;
        }
        @media (min-width: 991.98px) {
            .lists-layout-3 .other-category:first-child {
                padding-bottom: 20px;
                margin-bottom: 20px;
            }
        }
        .lists-layout-3 .items {
            position: relative;
        }
        .lists-layout-3 .items .imagen {
            overflow: hidden;
        }
        .lists-layout-3 .items .imagen img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
            transform: scale(1);
            transition: all 500ms ease-in-out;
        }
        .lists-layout-3 .items:after {
            content: '';
            background-color: rgba(60, 60, 59, 0.5);
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }
        .lists-layout-3 .items:nth-of-type(2):before {
            content: '';
            border-bottom: 1px solid #b4b4b4;
            position: absolute;
            bottom: -40px;
            display: block;
            height: 100%;
            z-index: 99;
            width: 100%;
        }
        .lists-layout-3 .items .card-img-overlay {
            margin: 20px;
            padding: 20px;
            border: 1px solid #fff;
            z-index: 99;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .lists-layout-3 .items h3 {
            font-size: 3.75rem;
            font-weight: bold;
        }
        .lists-layout-3 .items .btn {
            font-size: 0.938rem;
            border-radius: 0;
            color: #0A0808;
            background-color: rgba(255, 255, 255, 0.7);
        }
        .lists-layout-3 .items:hover img {
            transform: scale(1.1);
        }
        @media (max-width: 769px) {
            .lists-layout-3 .items h3 {
                font-size: 1.875rem;
            }
            .lists-layout-3 .items:nth-of-type(1):before, .lists-layout-3 .items:nth-of-type(2):before {
                border-bottom: 1px solid #b4b4b4;
                bottom: -20px;
            }
        }

    </style>
</section>
