<section id="breadcrumbSection">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-auto">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-5 pl-0">
            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">{{trans('isite::common.menu.home')}}</a></li>
            {{ $slot }}
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
