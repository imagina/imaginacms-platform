<div class="filter-{{$type}} filter-{{$type}}-layout-{{$layout}} filter-{{$name}}">

  <div class="content position-relative {{$wrapperClasses}}">
    @include('isite::frontend.partials.preloader')

    @foreach($this->options as $key => $option)

      @include('isite::frontend.livewire.filters.checkbox.layouts.checkbox-layout-3.option',['option'=> $option])

    @endforeach

  </div>

</div>

@once
  @include('isite::frontend.livewire.filters.checkbox.partials.style')
@endonce